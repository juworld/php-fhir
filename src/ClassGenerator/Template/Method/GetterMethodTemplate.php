<?php namespace DCarbone\PHPFHIR\ClassGenerator\Template\Method;

/*
 * Copyright 2016-2018 Daniel Carbone (daniel.p.carbone@gmail.com)
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

use DCarbone\PHPFHIR\ClassGenerator\Config;
use DCarbone\PHPFHIR\ClassGenerator\Template\Property\BasePropertyTemplate;
use DCarbone\PHPFHIR\ClassGenerator\Utilities\NameUtils;

/**
 * Class GetterMethodTemplate
 * @package DCarbone\PHPFHIR\ClassGenerator\Template
 */
class GetterMethodTemplate extends BaseMethodTemplate
{
    /** @var \DCarbone\PHPFHIR\ClassGenerator\Template\Property\BasePropertyTemplate */
    private $_property;

    /**
     * GetterMethodTemplate constructor.
     * @param \DCarbone\PHPFHIR\ClassGenerator\Config $config
     * @param \DCarbone\PHPFHIR\ClassGenerator\Template\Property\BasePropertyTemplate $propertyTemplate
     */
    public function __construct(Config $config, BasePropertyTemplate $propertyTemplate)
    {
        parent::__construct($config, sprintf('get%s', NameUtils::getPropertyMethodName($propertyTemplate->getName())));
        $this->setDocumentation($propertyTemplate->getDocumentation());
        $this->_property = $propertyTemplate;
    }

    protected function buildReturnDocBlockStatement()
    {
        $property = $this->getProperty();

        return sprintf(
            "     * @return %s%s%s\n",
            ($property->isPrimitive() || $property->isList() ? '' : '\\'),
            $property->getPHPType(),
            ($property->isCollection() ? '[]' : '')
        );
    }

    /**
     * @return BasePropertyTemplate
     */
    public function getProperty()
    {
        return $this->_property;
    }
}