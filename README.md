Tagger
======
*Tags, Categories, and More for MODX!*

A robust and performant tag management system. Summary of the many, many features:

1. Tested with up to a million tags 
2. Paginated drop-down and type-ahead for easy tag input
3. Combo-box or tag-field input types
4. Optionally remove unused tags from the database automatically
5. Optionally restrict tag creation to the CMP, versus on input
6. Optionally use Auto-Tag cloud for input

Display and list: all tags, tags from specified group(s), omit unused tags, Resources with a given tag, etc. Supplies getResources with a &where condition, so that all the templating and sorting abilities of getResources are at your fingertips. 

## Installation

Install via Package Management, or download the package from the [MODX Extras repository](http://modx.com/extras/)

## Basic Usage

### TaggerGetTags

This Snippet allows you to list tags for resource(s), group(s) and all tags

**PROPERTIES:**

&resources    Comma separated list of resources for which will be listed Tags

&groups       Comma separated list of Tagger Groups for which will be listed Tags

&rowTpl       Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered

&outTpl       Name of a chunk that will be used for wrapping all tags. If no chunk is given, tags will be rendered without a wrapper

&separator    String separator, that will be used for separating Tags

&target       An ID of a resource that will be used for generating URI for a Tag. If no ID is given, current Resource ID will be used

&showUnused   If set to 1, Tags that are not assigned to any Resource will be included to the output as well

**OUTPUT PLACEHOLDERS AND EXAMPLE VALUES:**

[id] => 1

[tag] => News

[group] => 3

[group_id] => 3

[group_name] => Media Type

[group_field_type] => tagger-combo-tag

[group_allow_new] => 0

[group_remove_unused] => 0

[group_allow_blank] => 1

[group_allow_type] => 0

[group_show_autotag] => 0

[group_show_for_templates] => 21

[cnt] => 1

[uri]

**EXAMPLE USAGE:**

```[[TaggerGetTags? &showUnused=`1`]]```

```[[TaggerGetTags? &groups=`1,3` &rowTpl=`tag_links_tpl`]]```

### TaggerGetResourcesWhere

This snippet generate SQL Query that can be used in WHERE condition in getResources snippet

**PROPERTIES:**

&tags       Comma separated list of Tags for which will be generated a Resource query. By default Tags from GET param will be loaded

&groups     Comma separated list of Tagger Groups. Only from those groups will Tags be allowed

&where      Original getResources where property. If you used where property in your current getResources call, move it here

**EXAMPLE USAGE:**

```[[!getResources? &where=`[[!TaggerGetResourcesWhere? &tags=`Books,Vehicles` &where=`{"isfolder": 0}`]]`]]```

## Documentation

Learn more about Tagger in the [Official Documentation](http://rtfm.modx.com/extras/revo/tagger).

## License

Tagger is GPL2. For the full copyright and license information, please view the license.txt file that was distributed with this source code, under /core/components/tagger/docs/.
