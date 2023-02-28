<?php

namespace StrehleDe\XmlToCypher\Import;

use Closure;
use DOMElement;
use Iterator;
use XMLReader;


class GraphXmlReader implements Iterator
{
    protected int $cnt = -1;
    protected XMLReader $xmlReader;


    /**
     * GraphXmlReader constructor.
     *
     * @param string $fileName
     * @param Closure $defaultHandler
     * @param Closure $statementHandler
     */
    public function __construct(
        protected string   $fileName,
        protected Closure $defaultHandler,
        protected Closure $statementHandler
    )
    {
        $this->xmlReader = new XMLReader();
    }


    /**
     * @return void
     */
    public function rewind(): void
    {
        if (!file_exists($this->fileName)) {
            return;
        }

        $ok = $this->xmlReader->open($this->fileName);

        // Go to the root node

        if ($ok) {
            $ok = $this->xmlReader->read();
        }

        if (!$ok) {
            return;
        }

        // Go to the first child node

        while (true) {
            $ok = $this->xmlReader->read();

            if (!$ok) {
                return;
            }

            if ($this->xmlReader->nodeType === XMLReader::ELEMENT) {
                $this->cnt = 0;

                return;
            }
        }
    }


    public function current(): mixed
    {
        /** @var DOMElement|bool $domNode */
        $domNode = $this->xmlReader->expand();

        if ($domNode === false) {
            return false;
        }

        if ($domNode->nodeType !== XML_ELEMENT_NODE) {
            return false;
        }

        if ($domNode->tagName === 'default') {
            return call_user_func($this->defaultHandler, $domNode);
        } elseif ($domNode->tagName === 'statement') {
            return call_user_func($this->statementHandler, $domNode);
        } else {
            return false;
        }
    }


    /**
     * @return int
     */
    public function key(): int
    {
        return $this->cnt;
    }


    /**
     * @return void
     */
    public function next(): void
    {
        while (true) {
            $ok = $this->xmlReader->next();

            if (!$ok) {
                $this->cnt = -1;

                return;
            }

            if ($this->xmlReader->nodeType === XMLReader::ELEMENT) {
                $this->cnt++;

                return;
            }
        }
    }


    /**
     * @return bool
     */
    public function valid(): bool
    {
        return ($this->cnt >= 0);
    }
}