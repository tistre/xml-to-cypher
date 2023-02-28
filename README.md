# xml-to-cypher

PHP script for converting a custom XML format to Neo4j Cypher statements

## Installation

Install dependencies:

```
% docker run --rm --interactive --tty --volume $PWD:/app --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp composer/composer install
```

## Usage

Convert XML to Cypher:

```
% cd /path/to/xml
% /path/to/xmltocypher.sh input.xml > output.cypher
```

Execute Cypher statements in Neo4j:

```
% cp output.cypher /path/to/neo4j-data/
% docker compose exec neo4j cypher-shell -u neo4j -p secret -f /data/output.cypher
```