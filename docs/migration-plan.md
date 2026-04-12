# Migration Plan for `InSquare/SeoBundle`

## Goal
Migrate from the legacy `leogout/seo-bundle` to the local `InSquare/SeoBundle` package without Twig backward-compatibility aliases.

## Scope of Changes
1. Twig function:
- replace all `{{ leogout_seo(...) }}` usages with `{{ insquare_seo(...) }}`.
- replace all `{{ leogout_seo() }}` usages with `{{ insquare_seo() }}`.

2. Service identifiers:
- replace the `leogout_seo.` prefix with `insquare_seo.` in:
  - service configuration (`services.yaml`, `services.xml`, and any bundle config),
  - controllers/services using `container->get(...)`,
  - integration tests.

3. Bundle configuration:
- ensure configuration is active under the `insquare_seo:` root key.
- move settings from `leogout_seo:` (if present) to `insquare_seo:`.

4. Bundle registration:
- verify `config/bundles.php` contains:
  - `InSquare\SeoBundle\InsquareSeoBundle::class => ['all' => true]`

## Rollout Strategy
1. Refactor names (`leogout_*` -> `insquare_*`) in code and templates.
2. Run unit and functional tests.
3. Perform smoke tests on pages rendering SEO tags inside `<head>`.
4. Validate rendered HTML:
- `{{ insquare_seo() }}` renders the full set of tags.
- `{{ insquare_seo('alias') }}` renders only the selected generator.

