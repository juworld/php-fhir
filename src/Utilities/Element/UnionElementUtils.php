<?php

namespace DCarbone\PHPFHIR\Utilities\Element;

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
use DCarbone\PHPFHIR\Definition\Type;
use DCarbone\PHPFHIR\Definition\Types;
use DCarbone\PHPFHIR\Enum\AttributeNameEnum;
use DCarbone\PHPFHIR\Utilities\BuilderUtils;
use DCarbone\PHPFHIR\Utilities\ExceptionUtils;

/**
 * Class UnionElementUtils
 * @package DCarbone\PHPFHIR\Utilities
 */
abstract class UnionElementUtils
{
    /**
     * @param \DCarbone\PHPFHIR\Config\VersionConfig $config
     * @param \DCarbone\PHPFHIR\Definition\Types $types
     * @param \DCarbone\PHPFHIR\Definition\Type $type
     * @param \SimpleXMLElement $union
     */
    public static function decorateType(VersionConfig $config, Types $types, Type $type, \SimpleXMLElement $union)
    {
        foreach ($union->attributes() as $attribute) {
            switch ($attribute->getName()) {
                case AttributeNameEnum::MEMBER_TYPES:
                    BuilderUtils::setArrayFromAttribute($type, $union, $attribute, 'setUnionOf');
                    break;

                default:
                    throw ExceptionUtils::createUnexpectedAttributeException($type, $union, $attribute);
            }
        }

        foreach ($union->children('xs', true) as $child) {
            switch ($child->getName()) {

                default:
                    throw ExceptionUtils::createUnexpectedElementException($type, $union, $child);
            }
        }
    }
}