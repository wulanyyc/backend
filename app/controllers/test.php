<?php

$app->post('/test', function () use ($app) {
    $params = $app->request->getRawBody();
    return $params;
});

