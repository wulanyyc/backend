<?php

$app->get('/test', function () use ($app) {
    $params = $app->request->getRawBody();
    return $params;
});

