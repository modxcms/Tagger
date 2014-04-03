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

PROPERTIES:
&resources    Comma separated list of resources for which will be listed Tags
&groups       Comma separated list of Tagger Groups for which will be listed Tags
&rowTpl       Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered
&outTpl       Name of a chunk that will be used for wrapping all tags. If no chunk is given, tags will be rendered without a wrapper
&separator    String separator, that will be used for separating Tags
&target       An ID of a resource that will be used for generating URI for a Tag. If no ID is given, current Resource ID will be used
&showUnused   If set to 1, Tags that are not assigned to any Resource will be included to the output as well

EXAMPLE USAGE:

```[[TaggerGetTags? &showUnused=`1`]]```



## Documentation

Learn more about Tagger in the [Official Documentation](http://rtfm.modx.com/extras/revo/tagger).

## License

Tagger is GPL2. For the full copyright and license information, please view the license.txt file that was distributed with this source code, under /core/components/tagger/docs/.
