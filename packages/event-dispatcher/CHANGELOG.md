# Changelog

All notable changes to `event-dispatcher` will be documented in this file.

## 1.1.1 - 2021-08-06

- Fix error with `PrioritizedListenerProvider` initialization in `ConfigProvider`.

## 1.1.0 - 2021-08-06

- Now dispatcher throws `A50\EventDispatcher\Infrastructure\CouldNotFindListener::class` exception if listener 
  was not found for event;
  
- `A50\EventDispatcher\Infrastructure\Config::class` methods were updated.

## 1.0.0 - 2021-07-23

- Initial release.
