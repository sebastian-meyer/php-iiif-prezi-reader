<?php
namespace iiif\presentation\v2\model\resources;

use iiif\presentation\v2\model\vocabulary\Names;
use iiif\presentation\IiifHelper;

class AnnotationList extends AbstractIiifResource {

    const TYPE = "sc:AnnotationList";

    /**
     *
     * @var Annotation[]
     */
    protected $resources = array();

    private $resourcesLoaded = false;

    /**
     *
     * {@inheritdoc}
     * @see \iiif\presentation\v2\model\resources\AbstractIiifResource::fromArray()
     */
    public static function fromArray($jsonAsArray, &$allResources = array()) {
        $annotationList = self::createInstanceFromArray($jsonAsArray, $allResources);
        $annotationList->loadPropertiesFromArray($jsonAsArray, $allResources);
        $annotationList->loadResources($jsonAsArray, Names::RESOURCES, Annotation::class, $annotationList->resources, $allResources);
        return $annotationList;
    }

    /**
     *
     * @return \iiif\presentation\v2\model\resources\Annotation[]
     */
    public function getResources() {
        if ($resources == null && ! $this->resourcesLoaded) {
            
            $content = file_get_contents($this->id);
            $jsonAsArray = json_decode($content, true);
            
            $remoteAnnotationList = IiifHelper::loadIiifResource($content);
            
            $this->resources = $remoteAnnotationList->resources;
            
            // TODO register resources in manifest (i.e. replace $dummy with actual resources array somehow)
            
            $this->resourcesLoaded = true;
        }
        return $this->resources;
    }
}

