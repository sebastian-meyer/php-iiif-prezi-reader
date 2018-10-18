<?php
namespace iiif\presentation;

use iiif\context\IRI;
use iiif\context\Keywords;
use iiif\presentation\common\model\AbstractIiifEntity;
use iiif\presentation\v2\model\constants\Profile;
use iiif\presentation\v2\model\helper\IiifReader;
use iiif\presentation\v2\model\resources\AbstractIiifResource;
use iiif\presentation\v2\model\resources\Canvas;
use iiif\presentation\v2\model\resources\Manifest;
use iiif\presentation\v2\model\resources\Range;
use iiif\presentation\v2\model\resources\Sequence;
use iiif\presentation\v2\model\vocabulary\Names;
use iiif\presentation\v3\model\resources\AbstractIiifResource3;
use iiif\presentation\v3\model\resources\Annotation3;
use iiif\presentation\v3\model\resources\AnnotationPage3;
use iiif\presentation\v3\model\resources\Canvas3;
use iiif\presentation\v3\model\resources\ContentResource3;
use iiif\presentation\v3\model\resources\Manifest3;
use iiif\presentation\v3\model\resources\Range3;

class IiifHelper {

    const PRESENTATION_API_2_CONTEXT = "http://iiif.io/api/presentation/2/context.json";

    const PRESENTATION_API_3_CONTEXT = "http://iiif.io/api/presentation/3/context.json";

    public static function loadIiifResource($resource) {
        if (is_string($resource)) {
            if (IRI::isAbsoluteIri($resource) && parse_url($resource)) {
                $resource = file_get_contents($resource);
            }
            $resource = json_decode($resource, true);
        }
        if (is_array($resource)) {
            if (array_key_exists(Keywords::CONTEXT, $resource)) {
                $context = $resource[Keywords::CONTEXT];
                if (is_array($context)) {
                    foreach ($context as $ctx) {
                        $iiif = self::getResourceForContext($ctx, $resource);
                        if ($iiif != null) {
                            return $iiif;
                        }
                    }
                } else {
                    return self::getResourceForContext($context, $resource);
                }
            }
        }
        return null;
    }

    private static function getResourceForContext($context, $resource) {
        if ($context == self::PRESENTATION_API_2_CONTEXT) {
            $iiifClass = IiifReader::getResourceClassForArray($resource);
            return $iiifClass::loadIiifResource($resource);
        }
        if ($context == self::PRESENTATION_API_3_CONTEXT) {
            return AbstractIiifResource3::loadIiifResource($resource);
        }
        return null;
    }

    public static function getStartCanvasOrFirstCanvas(AbstractIiifEntity $resource) {
        if ($resource instanceof Manifest3 || $resource instanceof Range3) {
            if ($resource->getStart() != null)
                return $resource->getStart();
            if ($resource->getItems() != null && sizeof($resource->getItems()) > 0) {
                if ($resource instanceof Manifest3) {
                    return $resource->getItems()[0];
                }
                if ($resource instanceof Range3) {
                    return $resource->getAllCanvases()[0];
                }
            }
            return null;
        }
        if ($resource instanceof Manifest || $resource instanceof Range || $resource instanceof Sequence || $resource instanceof Canvas) {
            $resource->getStartCanvasOrFirstCanvas();
        }
    }

    public static function getThumbnailUrlForIiifResource(AbstractIiifEntity $resource, $width = null, $height = null, &$thumbnailServiceProfiles = array(), $classWithStaticGetUrlMethod = null) {
        if ($resource->getThumbnail() != null) {
            if (is_string($resource->getThumbnail())) {
                return $resource->getThumbnail();
            } elseif ($resource->getThumbnail() instanceof ContentResource3) {
                $resource->getThumbnail()->getImageUrl();
            }
        }
        if ($resource instanceof AbstractIiifResource) {
            $canvas = null;
            $imageAnnotation = null;
            $image = null;
            if ($resource instanceof Manifest) {
                if ($resource->getSequences() != null && $resource->getSequences()[0] != null) {
                    $sequence = $resource->getSequences()[0];
                    /* @var $sequence \iiif\presentation\v2\model\resources\Sequence */
                    
                    if ($sequence->getThumbnail() != null) {
                        return $sequence->getThumbnail()->getImageUrl();
                    }
                    if ($sequence->getCanvases() != null && is_array($sequence->getCanvases())) {
                        $canvas = $resource->getSequences()[0]->getCanvases()[0];
                    }
                }
            } elseif ($resource instanceof Sequence) {
                if ($resource->getCanvases() != null && array_key_exists(0, $resource->getCanvases())) {
                    $canvas = $resource->getCanvases()[0];
                }
            } elseif ($resource instanceof Canvas) {
                $canvas = $resource;
            }
            
            if ($canvas != null && $canvas->getImages() != null && array_key_exists(0, $canvas->getImages())) {
                $imageAnnotation = $canvas->getImages()[0];
            }
            if ($imageAnnotation == null)
                return null;
            if ($imageAnnotation->getResource() != null) {
                $image = $imageAnnotation->getResource();
            }
            
            if ($image->getThumbnail() != null) {
                $thumbnailUrl = $image->getThumbnail()->getImageUrl();
            } elseif ($image->getService() != null && $image->getService()->getProfile() != null) {
                // thumbnail is not already provided by canvas or image - try to generated thumbnail URL for iiif image server
                $profile = $image->getService()->getProfile();
                $sizeByW = false;
                $sizeByConfinedWh = false;
                if (array_key_exists($profile, $thumbnailServiceProfiles)) {
                    // profile has been seen before
                    $sizeByW = in_array(Profile::SIZE_BY_W, $thumbnailServiceProfiles[$profile]);
                    $sizeByConfinedWh = in_array(Profile::SIZE_BY_CONFINED_WH, $thumbnailServiceProfiles[$profile]);
                } elseif (array_key_exists($profile, Profile::SUPPORTED_BY_LEVEL)) {
                    // IIIF profile?
                    $sizeByW = in_array(Profile::SIZE_BY_W, Profile::SUPPORTED_BY_LEVEL[$profile]);
                    $sizeByConfinedWh = in_array(Profile::SIZE_BY_CONFINED_WH, Profile::SUPPORTED_BY_LEVEL[$profile]);
                    $thumbnailServiceProfiles[$profile] = Profile::SUPPORTED_BY_LEVEL[$profile];
                } else {
                    try {
                        // Try to load profile
                        if ($classWithStaticGetUrlMethod != null) {
                            $profileContent = $classWithStaticGetUrlMethod::getUrl($profile);
                        } else {
                            $profileContent = file_get_contents($profile);
                        }
                        if ($profileContent != null && $profileContent != false) {
                            $profileArray = json_decode($profileContent, true);
                            if (array_key_exists(Names::SUPPORTS, $profileArray)) {
                                // Check "supports" field for resizing
                                $sizeByW = in_array(Profile::SIZE_BY_W, $profileArray[Names::SUPPORTS]);
                                $sizeByConfinedWh = in_array(Profile::SIZE_BY_CONFINED_WH, $profileArray[Names::SUPPORTS]);
                                $thumbnailServiceProfiles[$profile] = $profileArray[Names::SUPPORTS];
                            }
                        }
                    } catch (\Exception $e) {}
                    if (! in_array($profile, $thumbnailServiceProfiles)) {
                        $assumedProfile = null;
                        // if profile cannot be analyzed, check if it contains a "level" string and assume that this is a valid IIIF image api compliance level.
                        // This is the case for old UBL manifests.
                        if (strpos($profile, 'level0') !== false) {
                            $assumedProfile = Profile::IIIF2_LEVEL0;
                        } elseif (strpos($profile, 'level1') !== false) {
                            $assumedProfile = Profile::IIIF2_LEVEL1;
                        } elseif (strpos($profile, 'level2') !== false) {
                            $assumedProfile = Profile::IIIF2_LEVEL2;
                        }
                        if ($assumedProfile != null) {
                            $sizeByW = in_array(Profile::SIZE_BY_W, Profile::SUPPORTED_BY_LEVEL[$assumedProfile]);
                            $sizeByConfinedWh = in_array(Profile::SIZE_BY_CONFINED_WH, Profile::SUPPORTED_BY_LEVEL[$assumedProfile]);
                            $thumbnailServiceProfiles[$profile] = Profile::SUPPORTED_BY_LEVEL[$assumedProfile];
                        }
                    }
                }
                
                if (! array_key_exists($profile, $thumbnailServiceProfiles)) {
                    // no supported profile found
                    $thumbnailServiceProfiles[$profile] = array();
                }
                
                // region: full, rotation:0 and quality:default and format:jpg are supported by level 0; for the size we need to check the supported features.
                if ($sizeByConfinedWh) {
                    $thumbnailUrl = $image->getService()->getId() . '/full/!100,150/0/default.jpg';
                } elseif ($sizeByW) {
                    $thumbnailUrl = $image->getService()->getId() . '/full/100,/0/default.jpg';
                }
            }
            return $thumbnailUrl;
        } elseif ($resource instanceof AbstractIiifResource3) {
            if ($resource instanceof Manifest3 || $resource instanceof Range3) {
                return empty($resource->getItems()) ? null : self::getThumbnailUrlForIiifResource(self::getStartCanvasOrFirstCanvas($resource), $width, $height, $thumbnailServiceProfiles, $classWithStaticGetUrlMethod);
            } elseif ($resource instanceof Canvas3) {
                return empty($resource->getItems()) ? null : self::getThumbnailUrlForIiifResource($resource->getItems()[0], $width, $height, $thumbnailServiceProfiles, $classWithStaticGetUrlMethod);
            } elseif ($resource instanceof AnnotationPage3) {
                if (empty($resource->getItems())) {
                    return null;
                }
                foreach ($resource->getItems() as $annotation) {
                    /* @var $annotation Annotation3 */
                    if ($annotation->getMotivation() == "painting" && $annotation->getBody() != null && $annotation->getBody()->getType() == "Image") {
                        return self::getThumbnailUrlForIiifResource($annotation, $width, $height, $thumbnailServiceProfiles, $classWithStaticGetUrlMethod);
                    }
                }
            } elseif ($resource instanceof Annotation3) {
                return self::getThumbnailUrlForIiifResource($resource->getBody(), $width, $height, $thumbnailServiceProfiles, $classWithStaticGetUrlMethod);
            } elseif ($resource instanceof ContentResource3) {
                return $resource->getImageUrl($width, $height);
            }
        }
    }
}

