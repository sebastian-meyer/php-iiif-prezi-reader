<?php
namespace iiif\model\resources;

use iiif\model\properties\ViewingDirectionTrait;
use iiif\model\vocabulary\Names;
use iiif\model\vocabulary\Types;
use iiif\model\vocabulary\MiscNames;

class Range extends AbstractIiifResource
{
    use ViewingDirectionTrait;
    
    const TYPE="sc:Range";
    
    /**
     * 
     * @var Range[]
     */
    protected $ranges = array();
    /**
     * 
     * @var Canvas[]
     */
    protected $canvases = array();
    
    protected $members = array();
    
    protected $startCanvas;
    /**
     * {@inheritDoc}
     * @see \iiif\model\resources\AbstractIiifResource::fromArray()
     */
    public static function fromArray($jsonAsArray)
    {
        $range = new Range();
        $range->loadPropertiesFromArray($jsonAsArray);
        $range->loadResources($jsonAsArray, Names::CANVASES, Canvas::class, $range->canvases);
        $range->loadResources($jsonAsArray, Names::RANGES, Range::class, $range->ranges);
        
        $memberRanges=array(Names::TYPE=>Types::SC_RANGE, MiscNames::CLAZZ=>Range::class);
        $memberCanvases=array(Names::TYPE=>Types::SC_CANVAS, MiscNames::CLAZZ=>Canvas::class);
        $range->loadMixedResources($jsonAsArray, Names::MEMBERS, array($memberRanges, $memberCanvases), $range->members);
        
        // TODO load startcanvas
        // TODO set viewingDirection
        
        return $range;
    }
    /**
     * @return multitype:\iiif\model\resources\Range 
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * @return multitype:\iiif\model\resources\Canvas 
     */
    public function getCanvases()
    {
        return $this->canvases;
    }

    /**
     * @return multitype:
     */
    public function getMembers()
    {
        return $this->members;
    }



}

