CONTENTS OF THIS FILE
---------------------

* Introduction
* Requirements
* Installation
* Configuration

INTRODUCTION
------------

Pdf serialization module provides an extension for Views data export module to export data to PDF.
Module provides PDF format for the views.
* For a full description of the module visit: [pdf_serialization](https://www.drupal.org/project/pdf_serialization)


REQUIREMENTS
------------
This module requires the following outside of Drupal core.
* Views data export - [views_data_export](https://www.drupal.org/project/views_data_export)

INSTALLATION
------------

* Install as you would normally install a contributed Drupal module. Visit
  https://www.drupal.org/node/1897420 for further information.

CONFIGURATION
-------------

    1. Navigate to Administration > Extend and enable the module.
    2. Navigate to Administration > Structure > Views and create a View Page
       that will display the information that you want to filter and export
       (You will go to the path of this page to generate the export once done).
       The View can be whatever display/format type that you need as it will be
       the interface that the user will filter by and then export data from.
    3. Add the fields that you want to display and include in the export, then
       add the exposed filters that you want to filter by in order to create
       custom exports (user role, status, pretty much any field you need).
    4. Add a new display and select Data export.
    5. From the Format field set, select the Data export settings. Select pdf
       format. Apply.
    6. From the Pager field set, set to 'display all items' for the data export.
       Otherwise the results will be limited to the number per page in the pager
       settings.
    7. From the Path Settings field set, change the "Attach to" settings to
       "Page". Thats to attach the data export icon to the selected displays.
    8. Ensure that the 'path' for the data export is a file, with an extension
       matching the format. ie: /export/foo.pdf. Otherwise, the file will be
       downloaded without a file association.
    9. Navigate to the path of the View Page to generate the report.

MAINTAINERS
-----------

* Robertas Lazauskas (iRobertas) - https://www.drupal.org/u/irobertas
* Edvinas Baranauskas - https://www.drupal.org/u/edvinas-baranauskas
