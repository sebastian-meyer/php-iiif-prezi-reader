<?php
namespace iiif\model\helper;

use iiif\model\vocabulary\Types;
use iiif\model\vocabulary\Names;
use iiif\model\constants\Profile;
use iiif\model\resources\Manifest;
use iiif\model\resources\Sequence;
use iiif\model\resources\Canvas;

class IiifReader
{
    public static function getResourceClassForString($jsonAsString)
    {
        $jsonAsArray = json_decode($jsonAsString, true);
        return self::getResourceClassForArray($jsonAsArray);
    }
    public static function getResourceClassForArray($jsonAsArray)
    {
        if (!is_array($jsonAsArray) || !array_key_exists(Names::TYPE, $jsonAsArray))
        {
            return null;
        }
        $type = $jsonAsArray[Names::TYPE];
        if (array_key_exists($type, Types::IIIF_RESOURCE_TYPES))
        {
            return Types::IIIF_RESOURCE_TYPES[$type];
        }
        return null;
    }
    public static function getIiifResourceFromJsonString($jsonAsString)
    {
        $classForJson = self::getResourceClassForString($jsonAsString);
        return $classForJson::fromJson($jsonAsString);
    }
    
    public static function getThumbnailUrlForIiifResource($resource, &$thumbnailServiceProfiles=array(), $httpClient=null)
    {
        if ($resource->getThumbnail() != null){
            return $resource->getThumbnail()->getImageUrl();
        }
        $canvas = null;
        $imageAnnotation = null;
        $image = null;
        if ($resource instanceof Manifest) {
            if ($resource->getSequences() != null && $resource->getSequences()[0] != null)
            {
                $sequence = $resource->getSequences()[0];
                /* @var $sequence iiif\model\resources\Sequence */
                
                if ($sequence->getThumbnail()!=null) {
                    return $sequence->getThumbnail()->getImageUrl();
                }
                if ($sequence->getCanvases()!=null && is_array($sequence->getCanvases()))
                {
                    $canvas = $resource->getSequences()[0]->getCanvases();
                }
            }
        }
        elseif ($resource instanceof Sequence) {
            if ($resource->getCanvases() != null && array_key_exists(0, $resource->getCanvases())) {
                $canvas = $resource->getCanvases()[0];
            }
        }
        elseif ($resource instanceof Canvas) {
            $canvas = $resource;
        }
        
        if ($canvas != null && $canvas->getImages() != null && array_key_exists(0, $canvas->getImages())) {
            $imageAnnotation = $canvas->getImages()[0];
        }
        if ($imageAnnotation == null) return null;
        if ($imageAnnotation->getResource()!=null) {
            $image = $imageAnnotation->getResource();
        }
        
        if ($image->getThumbnail() != null) {
            $thumbnailUrl = $image->getThumbnail()->getImageUrl();
        }
        elseif ($image->getService() != null && $image->getService()->getProfile() != null) {
            // thumbnail is not already provided by canvas or image - try to generated thumbnail URL for iiif image server
            $profile = $image->getService()->getProfile();
            $resizingByWidthSupported = false;
            $resizingByWidthHeightSupported = false;
            if (array_key_exists($profile, $thumbnailServiceProfiles)) {
                // profile has been seen before
                $resizingByWidthSupported = in_array(Profile::SIZE_BY_W, $thumbnailServiceProfiles[$profile]);
                $resizingByWidthHeightSupported = in_array(Profile::SIZE_BY_WH, $thumbnailServiceProfiles[$profile]);
                
            }
            elseif (array_key_exists($profile, Profile::SUPPORTED_BY_LEVEL)) {
                // IIIF profile?
                $resizingByWidthSupported = in_array(Profile::SIZE_BY_W, Profile::SUPPORTED_BY_LEVEL[$profile]);
                $resizingByWidthHeightSupported = in_array(Profile::SIZE_BY_WH, Profile::SUPPORTED_BY_LEVEL[$profile]);
                $thumbnailServiceProfiles[$profile] = Profile::SUPPORTED_BY_LEVEL[$profile];
            }
            else {
                try
                {
                    // Try to load profile
                    if ($httpClient!=null) {
                        $profileContent = $httpClient::getUrl($profile);
                    }
                    else {
                        $profileContent = file_get_contents($profile);
                    }
                    if ($profileContent != null && $profileContent != false) {
                        $profileArray = json_decode($profileContent, true);
                        if (array_key_exists(Names::SUPPORTS, $profileArray)) {
                            // Check "supports" field for resizing
                            $resizingByWidthSupported = in_array(Profile::SIZE_BY_W, $profileArray[Names::SUPPORTS]);
                            $resizingByWidthHeightSupported = in_array(Profile::SIZE_BY_WH, $profileArray[Names::SUPPORTS]);
                            $thumbnailServiceProfiles[$profile] = $profileArray[Names::SUPPORTS];
                        }
                    }
                }
                catch (\Exception $e)
                {
                }
                if (!in_array($profile, $thumbnailServiceProfiles))
                {
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
                        $resizingByWidthSupported = in_array(Profile::SIZE_BY_W, Profile::SUPPORTED_BY_LEVEL[$assumedProfile]);
                        $resizingByWidthHeightSupported = in_array(Profile::SIZE_BY_WH, Profile::SUPPORTED_BY_LEVEL[$assumedProfile]);
                        $thumbnailServiceProfiles[$profile] = Profile::SUPPORTED_BY_LEVEL[$assumedProfile];
                    }
                }
            }
            
            if (!array_key_exists($profile, $thumbnailServiceProfiles))
            {
                // no supported profile found
                $thumbnailServiceProfiles[$profile] = array();
            }
            
            if ($resizingByWidthHeightSupported) {
                $thumbnailUrl=$image->getService()->getId().'/full/!100,150/0/default.jpg';
            } elseif ($resizingByWidthSupported) {
                $thumbnailUrl=$image->getService()->getId().'/full/100,/0/default.jpg';
            }
        }
        return $thumbnailUrl;
    }
}

