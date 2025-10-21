# kancelaria

## Automatyczne wdrożenie przez FTP

Ten projekt zawiera workflow GitHub Actions, który automatycznie wdraża wszystkie pliki na serwer FTP po każdym pushu do gałęzi `main`.

### Wymagane sekrety

Aby workflow działał poprawnie, należy skonfigurować następujące sekrety w ustawieniach repozytorium GitHub (Settings → Secrets and variables → Actions):

- `FTP_SERVER` - adres serwera FTP (np. `ftp.example.com`)
- `FTP_USERNAME` - nazwa użytkownika FTP
- `FTP_PASSWORD` - hasło użytkownika FTP
- `FTP_SERVER_DIR` - katalog docelowy na serwerze FTP (np. `/public_html/` lub `/`)

### Jak działa workflow

Workflow uruchamia się automatycznie po każdym pushu do gałęzi `main` i:
1. Pobiera wszystkie pliki z repozytorium
2. Łączy się z serwerem FTP używając podanych danych uwierzytelniających
3. Wysyła wszystkie pliki do określonego katalogu na serwerze