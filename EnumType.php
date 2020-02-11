<?php
namespace GollumSF\Doctrine;

use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use GollumSF\Enum\Enum as EnumEntity;

abstract class EnumType extends Type {
	const ENUM = 'enum';
	
	public abstract function getEnum(): string;
	
	protected function checkClass(): void {
		$class = $this->getEnum();
		if (!is_string($class) || !class_exists($class) || !is_subclass_of($class, EnumEntity::class)) {
			throw new InvalidArgumentException(sprintf(
				'The field declaration class %s not instance of %s',
				$class,
				EnumEntity::class
			));
		}
	}
	
	protected function checkValue($value): void {
		$enum = $this->getEnum();
		if (!call_user_func($enum.'::isValid', $value)) {
			throw new InvalidArgumentException(sprintf(
				'The value %s not valid forclass %s value must be: %S',
				$value,
				EnumEntity::class,
				implode(', ', call_user_func($enum.'::getValues'))
			));
		}
	}
	
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
		$this->checkClass();
		$enum = $this->getEnum();
		
		$values = array_map(function($value) {
			return '\''.str_replace('\'', '\\\'', $value).'\'';
		}, call_user_func($enum.'::getValues'));
		
		return 'ENUM('.implode(',', $values).')';
	}
	
	public function convertToPHPValue($value, AbstractPlatform $platform) {
		if ($value !== null) {
			$this->checkClass();
			$this->checkValue($value);
		}
		return $value;
	}
	
	public function convertToDatabaseValue($value, AbstractPlatform $platform) {
		if ($value !== null) {
			$this->checkClass();
			$this->checkValue($value);
		}
		return $value;
	}
	
	public function getName() {
		$this->checkClass();
		$class = get_class($this);
		$pos = strrpos($class, '\\');
		if ($pos !== false) {
			$class = substr($class, $pos+1);
		}
		$class = str_replace(' ', '_', mb_strtolower(trim(preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $class))));
		return self::ENUM.'_'.$class;
	}
}