#!/bin/bash

# Helper script for running the XML to Cypher conversion script on local files using Docker
#
# Has to be called from within the directory where the XML files reside (or a parent directory).
#
# Usage:
# % cd /path/to/xml
# % /path/to/xmltocypher.sh input.xml

APPDIR=`dirname "$0"`
WORKDIR=`realpath`

docker run --rm --interactive --tty --volume $APPDIR:/app --volume $WORKDIR:/data --workdir /data php:8.2 php /app/xmltocypher.php $*
