<?php
namespace GollumSF\Doctrine;

use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use GollumSF\Enum\Enum as EnumEntity;

class Enum extends Type {
	const ENUM = 'enum';
	
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
		$enum = $fieldDeclaration['enum'];
		if (!is_string($enum) || !class_exists($enum) || !is_subclass_of($enum, EnumEntity::class)) {
			throw new InvalidArgumentException(sprintf(
				'The field declaration class %s not instance of %s',
				$enum,
				EnumEntity::class
			));
		}
		
		$values = array_map(function($value) {
			return '\''.str_replace('\'', '\\\'', $value).'\'';
		}, call_user_func($enum.'::getValues'));
		
		return 'ENUM('.implode(',', $values).')';
	}
	
	public function convertToPHPValue($value, AbstractPlatform $platform) {
		return $value;
	}
	
	public function convertToDatabaseValue($value, AbstractPlatform $platform) {
		return $value;
	}
	
	public function getName() {
		return self::ENUM;
	}
}