Bolt CMS 3 - SEO Meta Manager
======================

This extension allows you to set meta data for any page of your site. 

You need only to specify the URI ($_SERVER['REQUEST_URI']) of the site page
without a domain but starting with a slash. This URI is to be used as key in the `meta` array.

For example:

```
   /               - key for page http://example.com/  (homepage)
   /contacts       - key for page http://example.com/contacts
   /page/info      - key for page http://example.com/page/info
```

Meta data should be defined in the config file of this extension.

```twig
    meta:
        /:                          # meta data for page http://example.com/  (homepage)
            title: Home
            description: My site description
            keywords: site, key
        /contacts:                  # meta data for page http://example.com/contacts
            title: Contacts
            description:
            keywords:
        /page/info:                 # meta data for page http://example.com/page/info
            title: Info
            description: Info page
            keywords: info, information
```

In your 'master' template you should use the following:

```HTML
    <title>{{ meta.title() }}</title>
    {{ meta.metatags() }}
```

We recommend to use this extension to set the metadata for listing-pages of your contenttypes and pages of your taxonomies. For metadata of your contenttype single pages we recommend to use [Bolt SEO extension](https://market.bolt.cm/view/bobdenotter/seo).

If you want to use both of these extensions, use the following:

```HTML
    <title>{% if meta.title() is not null %} {{ meta.title() }} {% else %} {{ seo.title() }} {% endif %}</title>
    {% if meta.metatags() is not null %} {{ meta.metatags() }} {% else %} {{ seo.metatags() }} {% endif %}
```

**Note:** With this change, if you will set seo data for a page with both Bolt SEO extension and SEO Meta Manager extension then the metadata from SEO Meta Manager extension will be applied.