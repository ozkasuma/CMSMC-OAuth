#!/bin/bash
#
# Build script for OAuth CMSMS module
# Creates distribution package (XML.gz) for Module Manager installation
#

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}Building OAuth module package...${NC}"

MODULE_NAME="OAuth"
MODULE_FILE="OAuth.module.php"

if [[ ! -f "$MODULE_FILE" ]]; then
    echo -e "${RED}Error: $MODULE_FILE not found${NC}"
    exit 1
fi

# Extract version (macOS compatible)
VERSION=$(sed -n "s/.*GetVersion().*return.*'\([^']*\)'.*/\1/p" "$MODULE_FILE" | head -1)
if [[ -z "$VERSION" ]]; then
    echo -e "${RED}Error: Could not extract version from $MODULE_FILE${NC}"
    exit 1
fi

echo -e "Module: ${YELLOW}$MODULE_NAME${NC}"
echo -e "Version: ${YELLOW}$VERSION${NC}"

# Create dist directory
DIST_DIR="dist"
mkdir -p "$DIST_DIR"

OUTPUT_FILE="$DIST_DIR/${MODULE_NAME}-${VERSION}.xml"
OUTPUT_GZ="$OUTPUT_FILE.gz"

# Files to include
INCLUDE_FILES=(
    "OAuth.module.php"
    "method.install.php"
    "method.uninstall.php"
    "action.*.php"
    "changelog.inc"
)

INCLUDE_DIRS=(
    "templates"
    "lang"
    "lib"
    "doc"
    "images"
)

# Start XML
cat > "$OUTPUT_FILE" << 'XMLHEADER'
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE module [
  <!ELEMENT module (dtdversion,name,version,mincmsversion,help,about,requires*,file+)>
  <!ELEMENT dtdversion (#PCDATA)>
  <!ELEMENT name (#PCDATA)>
  <!ELEMENT version (#PCDATA)>
  <!ELEMENT mincmsversion (#PCDATA)>
  <!ELEMENT help (#PCDATA)>
  <!ELEMENT about (#PCDATA)>
  <!ELEMENT requires (requiresname,requiresversion)>
  <!ELEMENT requiresname (#PCDATA)>
  <!ELEMENT requiresversion (#PCDATA)>
  <!ELEMENT file (filename,isdir,data)>
  <!ELEMENT filename (#PCDATA)>
  <!ELEMENT isdir (#PCDATA)>
  <!ELEMENT data (#PCDATA)>
]>
<module>
XMLHEADER

# Metadata (macOS compatible)
MIN_CMS_VERSION=$(sed -n "s/.*MinimumCMSVersion().*return.*'\([^']*\)'.*/\1/p" "$MODULE_FILE" | head -1)
[[ -z "$MIN_CMS_VERSION" ]] && MIN_CMS_VERSION="2.2.0"
ABOUT=$(sed -n "s/.*GetAuthor().*return.*'\([^']*\)'.*/\1/p" "$MODULE_FILE" | head -1)
[[ -z "$ABOUT" ]] && ABOUT="CMSMS Community"

cat >> "$OUTPUT_FILE" << XMLMETA
	<dtdversion>1.3</dtdversion>
	<name>$MODULE_NAME</name>
	<version>$VERSION</version>
	<mincmsversion>$MIN_CMS_VERSION</mincmsversion>
	<help><![CDATA[OAuth authentication for CMS Made Simple]]></help>
	<about><![CDATA[$ABOUT]]></about>
XMLMETA

add_file() {
    local filepath="$1"
    local data=""
    
    if [[ -f "$filepath" ]]; then
        data=$(base64 -i "$filepath" | tr -d '\n')
        echo "  Adding file: $filepath"
    fi
    
    cat >> "$OUTPUT_FILE" << XMLFILE
	<file>
		<filename>$filepath</filename>
		<isdir>0</isdir>
		<data><![CDATA[$data]]></data>
	</file>
XMLFILE
}

add_dir() {
    local dirpath="$1"
    cat >> "$OUTPUT_FILE" << XMLDIR
	<file>
		<filename>$dirpath</filename>
		<isdir>1</isdir>
		<data></data>
	</file>
XMLDIR
    echo "  Adding dir: $dirpath/"
}

# Add files
for pattern in "${INCLUDE_FILES[@]}"; do
    for file in $pattern; do
        if [[ -f "$file" ]]; then
            add_file "$file"
        fi
    done
done

# Add directories
for dir in "${INCLUDE_DIRS[@]}"; do
    if [[ -d "$dir" ]]; then
        add_dir "$dir"
        find "$dir" -type f ! -name '.DS_Store' ! -name '*.pyc' | while read file; do
            add_file "$file"
        done
    fi
done

echo "</module>" >> "$OUTPUT_FILE"

# Compress
gzip -f "$OUTPUT_FILE"

FINAL_SIZE=$(ls -lh "$OUTPUT_GZ" | awk '{print $5}')
echo ""
echo -e "${GREEN}✓ Build complete!${NC}"
echo -e "  Package: ${YELLOW}$OUTPUT_GZ${NC}"
echo -e "  Size: ${YELLOW}$FINAL_SIZE${NC}"
echo ""
echo "To install:"
echo "  1. Go to Extensions → Module Manager"
echo "  2. Click 'Upload Module'"
echo "  3. Select $OUTPUT_GZ"
