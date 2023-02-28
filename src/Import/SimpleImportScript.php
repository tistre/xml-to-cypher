<?php

namespace StrehleDe\XmlToCypher\Import;

use StrehleDe\XmlToCypher\Cypher\StatementTemplate;


class SimpleImportScript
{
    public function convertFileToCypher(string $filename): void
    {
        $statementTemplates = $this->getReader($filename);

        /** @var StatementTemplate|bool $statementTemplate */
        foreach ($statementTemplates as $statementTemplate) {
            if (!$statementTemplate) {
                continue;
            }

            echo $statementTemplate->getCypherText() . ";\n";
        }
    }


    protected function getReader(string $filename): GraphXmlReader
    {
        $graphXmlImporter = new GraphXmlImporter();

        return new GraphXmlReader(
            $filename,
            $graphXmlImporter->setDefault(...),
            $graphXmlImporter->getStatementTemplate(...)
        );
    }
}