<?php

use AmoCRM\Exceptions\AmoCRMApiException;

include_once __DIR__ . '/bootstrap.php';

$accessToken = getToken();

try {
    /**
     * В случае потери/смены субдомена аккаунта, мы можем его получить с помощью access_token
     * Сделав запрос на www.amocrm.ru/oauth2/account/subdomain
     *
     * Получим модель с информацией о домене аккаунта по access_token
     * Подробнее: @see AccountSubdomainModel
     *
     * Запрос уходит на www.amocrm.ru/oauth2/account/subdomain
     * С Authorization: Bearer {access_token}
     *
     * @example curl 'https://www.amocrm.ru/oauth2/account/subdomain' -H 'Authorization: Bearer {access_token}'
     */
    $accountSubdomainModel = $apiClient->getOAuthClient()
        ->getAccountSubdomain($accessToken);

    var_dump($accountSubdomainModel->toArray());

    // Возьмём из полученной модели текущий subdomain аккаунта и засетим наш субдомен аккаунта в апи клиенте
    $apiClient->setAccountBaseDomain($accountSubdomainModel->getSubdomain());

    var_dump($apiClient->getAccountBaseDomain());
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}
