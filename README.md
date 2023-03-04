# Kirby panel documentation view

A documentation view for the Kirby panel.

## Installation

`composer install samrm/kirby-panel-documentation`

## How to use this plugin

First create a `site/documentation` directory.

All the '.md' files in this directory will be used as pages to generate a menu in the view.

Numbers in filenames can be used to sort the pages.

Filenames are used as slugs for the routing.

Example of directory tree :

```
  site
  └── documentation
      ├── 1_section-a.md
      ├── 2_section-b.md
      └── ...

```

Each documentation page should contain the yaml keys `title` and `content`.

Example of documentation page template :

```markdown
title: The title of the page

----

content:

## A subtitle

Here goes the content of the page.

```

## License

MIT
