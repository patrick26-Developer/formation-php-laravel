# Running the Application

## Generate a report

```bash
php bin/generer-rapport.php donnees/ventes.csv "Sales Report" sortie/rapport.pdf
```

```
Report generated successfully: sortie/rapport.pdf
```

Open `sortie/rapport.pdf` with any PDF reader: a table reproducing the CSV's columns, with the generation date in the header.

## Generate a report with your own data

Replace `donnees/ventes.csv` with any CSV file (first line = column headers):

```bash
php bin/generer-rapport.php mon-fichier.csv "My Report" sortie/mon-rapport.pdf
```

## Error handling

```bash
php bin/generer-rapport.php fichier-inexistant.csv "Test" sortie/x.pdf
```
```
Error: File not found or unreadable: fichier-inexistant.csv
```
(exit code 1, usable in a shell/CI script)

## Running the tests

```bash
composer test
```

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
