<?php
$runner->setBootstrapFile( __DIR__ . '/tests/unit/bootstrap.php' );

// Code coverage report : HTML
$coverageField = new atoum\report\fields\runner\coverage\html(
    'Demo Generators',
    __DIR__.'/tests/unit/coverage-html'
);

$report = $script->AddDefaultReport();

$report->addField($coverageField);
