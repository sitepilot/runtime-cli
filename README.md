# Runtime CLI

Console application which generates configuration from blade templates.

## Usage

```bash
# Usage
./runtime config:generate <source-folder> <destination-folder> --configFile <yaml-config-file> --mergeFile <yaml-merge-file>

# Example
./runtime config:generate ./tests/Files/Templates ./storage/config --configFile ./tests/Files/config.yml --mergeFile ./tests/Files/merge.yml
```