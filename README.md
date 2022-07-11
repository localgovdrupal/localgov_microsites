# LocalGov Drupal Microsites

A repository for the LocalGov Drupal Microsites project.

As of 30th March, we are just starting a discovery sprint, so the respository is primarily for issues and requirements gathering at first.

Depending on the architecture, this repository may become the home for custom modules that deliver the new microsites functionality.

For installation steps, see: https://github.com/localgovdrupal/localgov_microsites_project

## Default content

This profile creates a single node of demo / default content using the https://www.drupal.org/project/default_content module.

This node includes layout paragraphs and paragraphs to demonstrate some of the components for a new microsite. When a new microsite is created, it attempts to clone this node into the new microsite. 

As developers, we often want to update this default content, using drush.

To export an item of content and all references:

```bash
lando drush dcer <entity type> <entity id> --folder=profiles/contrib/localgov_microsites/content/
```

So for node/1: 

```bash
lando drush dcer node 1 --folder=profiles/contrib/localgov_microsites/content/
```
