#!/bin/bash
cp ../*.c .
FILES="*.c"
echo "Copied files from dev folder..."
for f in $FILES; do
    echo "Compiling ${f} for amd64..."
    echo ""
    fileNameOutput="${f%.*}-amd64"
    gcc ${f} -o ${fileNameOutput}
    echo "Done crosscompiling${f} output file: ${fileNameOutput}."
    echo ""
done
echo "Compilation completed... Cleaning up environment..."
rm *.c
echo ""
echo "Creating Zip from files..."
zip wrappers-aamd64.zip * -x \*.\*
echo ""
echo "Complete!"
