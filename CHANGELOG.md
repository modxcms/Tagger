Changelog for Tagger.

Tagger 2.0.0
==============
- Add support for Revolution 3.0.0
- Remove group placement above/under content

Tagger 1.12.0
==============
- Add 404 handler for invalid tags. 

Tagger 1.11.0
==============
- Move the Gateway handler from OnHandleRequest to OnPageNotFound
- Fix FURL issue with Revo >= 2.7.0

Tagger 1.10.0
==============
- Add URI to TaggerGetCurrentTag snippet
- Add linkOneTagPerGroup option to TaggerGetTags
- Add option to include current tags in TaggerGetTags url
- Add Tag Label for frontend usage
- Add scheme override to TaggerGetTags properties
- Add an option (through system settings) to preserve accent characters in tag/group alias

Tagger 1.9.0
==============
- Add noActiveTags placeholder to the outTpl of TaggerGetTags snippet
- If TV tab is not present, add all Tagger groups to Tagger tab
- Add ability to show Tagger only for specific contexts 
- Remove accent chars from tag's & group's alias
- Fix adding tags from field
- Add ability to sort tags in manager by rank or alias
- Add sample translation to custom lexicon
- Fix assign from field when tag limit is set
- Fix alphabetic sorting of tags
- Add As Radio option to the Tagger Group
- Fix updating hidden textfield

Tagger 1.8.0
==============
- Sort tags by tag asc in the form
- Sort tags by tag asc when suggesting them
- Fix TaggerGetRelatedWhere to pass alias instead of tag
- Add TaggerGetCurrentTag snippet
- Add active placeholder to TaggerGetTags rowTpl to identify currently active tag
- Add parent option to TaggerGetTags
- RU lexicons (credits goes to mvoevodskiy)
- Fix deleting multiple tags at once
- Decode HTML entities when setting value
- Include script properties to TaggerGetTags chunks

Tagger 1.7.0
==============
- Match group by alias or name in TaggerGetResourcesWhere
- Add TaggerGetRelatedWhere snippet
- Class for each plugin event
- Hide tag limit field for combo box input
- Fix gateway for index page
- Load values for Tagger fields under TVs properly
- Add field option to TaggerGetResourcesWhere
- New styles for Revolution 2.3
- Added @INLINE support in TaggerGetTags tpls params
- Added &weight parameter to TaggerGetTags
- Fixed matchAll parameter in TaggerGetResourcesWhere

Tagger 1.6.0
==============
- Added friendlyURL option to TaggerGetTags
- Added matchAll option to TaggerGetResourcesWhere

Tagger 1.5.1
==============
- Fixed compatibility with PHP 5.2

Tagger 1.5.0
==============
- Added option to translate Tagger groups
- Added system settings for changing place's labels
- Added an option to place a group as a tab into TVs section
- Added option &wrapIfEmpty

Tagger 1.4.0
==============
- Updated french translations
- Fixed gateway to support all file extensions
- Made combobox for tags 100% width
- Put form labels to top
- Added lexicon string for Tagger's tab
- Updated styles to look better in 2.3
- Added tagField to GetResourcesWhere snippet
- Added sort param to GetTags snippet
- Added Group description
- Changed labelSeparator
- Fixed notice in GetTags snippet
- Fixed logging messages from plugin
- Updated GetResourcesWhere snippet and removed tag_key init

Tagger 1.3.1
==============
- Fixed autotag styles in Revolution 2.3
- Fixed tag's styles inside tag field in Revolution 2.3

Tagger 1.3.0
==============
- Fixed bug that removed all assigned tags on second resource's save
- Added alias field to groups
- Added alias field to tags
- Added option to limit number of selected tags
- Added option to use LIKE in query in TaggerGetResourcesWhere snippet
- Fixed tag count when using showDeleted = 0 or showUnpublished = 0
- Added an option to hide input field when auto tag is showed
- Added limit, offset, totalPh, tpl_N properties to TaggerGetTags snippet
- Fixed gateway redirecting to URL ended with a comma

Tagger 1.2.0
==============
- Added merge selected Tags
- Added remove selected Tags
- Fixed IndexManagerController
- Added options showDeleted and showUnpublished to snippet getTags
- Fixed getResourcesWhere to not return null when no tags are provided

Tagger 1.1.0
==============
- Added toPlaceholder property to getTags snippet
- Duplicate Tags also for children
- Improved gateway
- Added handler for onResourceDuplicate event, that copies Tags (only for the Resource, not for children)
- Added contexts property to TaggerGetTags snippet

Tagger 1.0.2
==============
- Replaced calling shorthand PHP array [] with default array()

Tagger 1.0.1
==============
- Fixed default value for &target in TaggerGetTags
- Added descriptions to add/update group window
- Fixed &group property in TaggerGetTags snippet

Tagger 1.0.0
==============
- Added ability to show assigned resources for selected tag from Tag grid
- Added system settings to show/hide header of group places
- Added option to select place where to render Tagger Group
- Added import button to Tagger Group grid
- Added drag & drop groups reorder
- Added position to Tagger group

Tagger 0.4.1
==============
- Fixed group add dialog

Tagger 0.4.0
==============
- Added snippets properties
- Translated system settings
- Improved Snippets documentation
- Added autotag option for groups that have field type set to Tag field
- Fixed updating tags from manager
- Added PHP documentation to xPDO classes
- Added an option to show only used tags in TaggerGetTags
- Added Allow type option to groups
- Added trigger button to the tagger field

Tagger 0.3.0
==============
- Added url placeholder into TaggerGetTags row tpl
- Added gateway for handling friendly URL with tags
- Added snippet for creating WHERE query that can be used in getResources
- Removed snippet for listing resources by tags

Tagger 0.2.0
==============
- Fixed removing tags after quick save
- Fixed removing old tag - resource relations
- Fixed removing unused tags
- Added snippet for listing resources by tags
- Added snippet for listing tags

Tagger 0.1.0
==============
- Updated schema - added indexes, removed ID from TaggerTagResource
- Speed improvements in retrieving tags
- Added groups options: field_type, allow_new, remove_unused and allow_blank
- Added combobox for tags
- Added tag field
- Added sorting option to tag and group grids
- Tag management
- Group management
- Initial release.
