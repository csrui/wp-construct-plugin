# WP Construct - Plugin Edition

## Main Goals

- [x] Use composer to make the code available
- [ ] Heavily documented to help other devs.
- [ ] It should greatly improve DRY avoiding the current code / file repetition on every plugin.
- [ ] Automate as much as possible without sacrificing customization.
- [ ] Contain unit tests
- [ ] Reduce the yeoman generator's output.

## How To use

The steps reproduced here could be handled by some sort of generator like yeoman.

### Setup dependencies

Using composer, require the base library.

```bash
composer require "csrui/wp-construct-plugin"
```

Using a calendar plugin as example, here are the necessary files to files and logic:
