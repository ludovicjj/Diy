<?php

$name = $request->query->get('name', 'World');
$content = sprintf('Hello %s', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));

$response->headers->set('Content-Type', 'text/html; charset=utf-8');
$response->setContent($content);
