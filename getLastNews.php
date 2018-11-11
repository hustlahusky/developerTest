<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Web\HttpClient;

/**
 * Load items from rss channel
 * @param string $rss link to rss
 * @param int $count items count to read
 * @return array
 */
function loadRssItems($rss, $count = 5) {
	$client = new HttpClient;

	$client->get($rss);

	$response = $client->getResult();

	$xml = simplexml_load_string($response);

	$result = [];

	for ($i = 0; $i < 5; $i++) {
		$result[] = [
			'name' => (string) $xml->channel->item[$i]->title,
			'link' => (string) $xml->channel->item[$i]->link,
			'description' => trim((string) $xml->channel->item[$i]->description),
		];
	}

	return $result;
}

/**
 * Pretty print
 * @param array $items
 */
function prettyPrint(array $items) {
	$first = true;
	foreach ($items as $item) {
		if (!$first) {
			echo "\n\n---------\n\n";
		}

		$first = false;

		echo "Название: ${item['name']}\n";
		echo "Ссылка на новость: ${item['link']}\n";
		echo "Анонс:\n\n";
		echo "${item['description']}";
	}

	echo "\n";
}

$lentaRu = loadRssItems('https://lenta.ru/rss');

prettyPrint($lentaRu);
