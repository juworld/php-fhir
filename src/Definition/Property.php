<?php

namespace DCarbone\PHPFHIR\Definition;

/*
 * Copyright 2016-2019 Daniel Carbone (daniel.p.carbone@gmail.com)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use DCarbone\PHPFHIR\Config\VersionConfig;

/**
 * Class Property
 * @package DCarbone\PHPFHIR\Definition
 */
class Property
{
    use DocumentationTrait;

    /** @var \DCarbone\PHPFHIR\Config\VersionConfig */
    private $config;

    /** @var string */
    private $name;

    /** @var string */
    private $fhirTypeName;

    /** @var \SimpleXMLElement */
    private $sourceSXE;

    /** @var int */
    private $minOccurs = 0;
    /** @var int */
    private $maxOccurs = 1;

    /** @var string|null */
    private $pattern = null;

    /** @var null|\DCarbone\PHPFHIR\Definition\Type */
    private $valueType = null;

    /**
     * Property constructor.
     * @param \DCarbone\PHPFHIR\Config\VersionConfig $config
     * @param string $name
     * @param string $fhirTypeName
     * @param \SimpleXMLElement $sxe
     */
    public function __construct(VersionConfig $config, $name, $fhirTypeName, \SimpleXMLElement $sxe)
    {
        $this->config = $config;
        $this->name = $name;
        $this->fhirTypeName = $fhirTypeName;
        $this->sourceSXE = $sxe;
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'name'         => $this->getName(),
            'fhirTypeName' => $this->getFHIRTypeName(),
            'sourceSXE'    => $this->getSourceSXE(),
            'minOccurs'    => $this->getMinOccurs(),
            'maxOccurs'    => $this->getMaxOccurs(),
            'pattern'      => $this->getPattern(),
            'valueType'    => (string)$this->getValueType(),
        ];
    }

    /**
     * @return \DCarbone\PHPFHIR\Config\VersionConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFHIRTypeName()
    {
        return $this->fhirTypeName;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getSourceSXE()
    {
        return $this->sourceSXE;
    }

    /**
     * @return int
     */
    public function getMaxOccurs()
    {
        return $this->maxOccurs;
    }

    /**
     * @param int $maxOccurs
     * @return Property
     */
    public function setMaxOccurs($maxOccurs)
    {
        if (is_string($maxOccurs) && 'unbounded' === strtolower($maxOccurs)) {
            $this->maxOccurs = PHPFHIR_UNLIMITED;
        } else {
            $this->maxOccurs = (int)$maxOccurs;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getMinOccurs()
    {
        return $this->minOccurs;
    }

    /**
     * @param int $minOccurs
     * @return Property
     */
    public function setMinOccurs($minOccurs)
    {
        $this->minOccurs = (int)$minOccurs;
        return $this;
    }

    /**
     * If defined, this is a regex pattern by which to validate the contents.
     *
     * @return null|string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return Property
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return \DCarbone\PHPFHIR\Definition\Type|null
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * @param \DCarbone\PHPFHIR\Definition\Type $valueType
     * @return \DCarbone\PHPFHIR\Definition\Type\Property
     */
    public function setValueType(Type $valueType)
    {
        $this->valueType = $valueType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCollection()
    {
        return PHPFHIR_UNLIMITED === ($o = $this->getMaxOccurs()) || 1 < $o;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return 1 <= $this->getMinOccurs();
    }

    /**
     * @return bool
     */
    public function unlimitedOccurrences()
    {
        return PHPFHIR_UNLIMITED === $this->getMaxOccurs();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}