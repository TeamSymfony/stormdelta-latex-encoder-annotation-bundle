<?php

namespace StormDelta\LatexEncoder\AnnotationBundle\Annotation\Driver;

use Doctrine\Common\Annotations\Reader;
use StormDelta\LatexEncoder\AnnotationBundle\Encoder\LatexEncoder;

class LatexEncoderAnnotationDriver
{
    private $reader;
    private $encoder;

    public function __construct(Reader $reader, LatexEncoder $encoder)
    {
        $this->reader = $reader;
        $this->encoder = $encoder;
    }

    public function encode($entity)
    {
        $reflectionClass = new \ReflectionClass($entity);

        $properties = $reflectionClass->getProperties();

        $annotation = false;
        $property = false;

        foreach ($properties as $prop) {
            $annotation = $this->reader->getPropertyAnnotations($prop, 'StormDelta\\LatexEncoder\\AnnotationBundle\\Annotation\\LatexEncoderAnnotation');

            foreach ($annotation as $a) {
                if (get_class($a) === 'StormDelta\LatexEncoder\AnnotationBundle\Annotation\LatexEncoderAnnotation') {
                    if (!empty($annotation)) {
                        $property = $prop->getName();
                    }

                    if (!empty($property)) {
                        $property = (str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
                        $setMethod = 'set'.($property);
                        $getMethod = 'get'.($property);
                        if (method_exists($entity, $setMethod) && method_exists($entity, $getMethod)) {
                            $string = $entity->{$getMethod}();

                            $encoded_string = $this->encoder->encode($string);

                            $entity->{$setMethod}($encoded_string);
                        }
                    }
                }

                if (get_class($a) === 'StormDelta\LatexEncoder\AnnotationBundle\Annotation\LatexEncoderFollowAnnotation') {
                    if (!empty($annotation)) {
                        $property = $prop->getName();
                    }

                    if (!empty($property)) {
                        $property = (str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
                        $getMethod = 'get'.($property);

                        foreach ($entity->{$getMethod}() as $object) {
                            $object = $this->encode($object);
                        }
                    }
                }
            }
        }

        return $entity;
    }
}
