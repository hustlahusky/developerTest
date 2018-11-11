<?php

namespace hustlahysky\developerTest;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use Exception;

class CustomIblockElement {
	/**
	 * Get iblock elements using Bitrix ORM with cache enabled by default
	 *
	 * @param array $parameters query parameters for Bitrix ORM
	 * @return Bitrix\Main\ORM\Query\Result
	 * @throws Exception
	 */
	static function getList(array $parameters = []) {
		if (!Loader::includeModule('iblock')) {
			throw new Exception('iblock module does not installed');
		}

		$parameters = array_merge([
			'cache' => [
				'ttl' => 86400,
				'cache_joins' => true,
			],
		], $parameters);

		return ElementTable::getList($parameters);
	}
}

// Usage example
// require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
//
// $elements = CustomIblockElement::getList([
// 	'filter' => [
// 		'ACTIVE' => 'Y',
// 		'IBLOCK_ID' => 1,
// 	],
// ])->fetchAll();
//
// var_dump($elements);
