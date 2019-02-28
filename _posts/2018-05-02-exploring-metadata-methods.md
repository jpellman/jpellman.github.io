---
layout: post
title:  "A Prescriptive Taxonomy of Methods for Adding Metadata to Files"
date:   2018-05-02 00:23:26
permalink: /metadata.html
---

*TODO*: Add discussion of https://bmcresnotes.biomedcentral.com/articles/10.1186/1756-0500-2-53
https://frictionlessdata.io/
https://5stardata.info/en/

In my previous life as a neuroscience research assistant, I worked with an actively-developed data organization standard known as the [Brain Imaging Data Structure](http://bids.neuroimaging.io/) (BIDS).  Due to my experience working with BIDS, I became increasingly interested in methdologies used for capturing metadata related to scientific experiments and making datasets more discoverabley evolved into a more generalized interest in metadata management for digital formats.  The following is a summary of the methods I've come across, in part based on this [reddit post on r/datahoarder](https://www.reddit.com/r/DataHoarder/comments/7sqq7g/metadata_container_standard_for_arbitrary_files/) (and [this one](https://www.reddit.com/r/DataHoarder/comments/7jz2da/metadatatags_for_video_material/) as well), as well as my experiences working in an academic library.  It contains some strong opinions based off my experiences, and thus I have come to classify it as a "prescriptive taxonomy".

## Metadata Encoded in Filenames

Many librarians specializing in data management will advise researchers to use descriptive filenames for their research (for instance [here](https://library.stanford.edu/research/data-management-services/data-best-practices/best-practices-file-naming)).  In neuroimaging, the BIDS standard enforces the inclusion of metadata in the filename and directory structure by means of a number of key/value pairs separated by underscores, ending with the type of scan used.  For instance, a filename of ``sub-control01_T1w.nii.gz`` would indicate that the data within the file belongs to a participant (subject) designated ``control01`` and that the kind of scan used is a T1w scan (these are used to provide high fidelity images of basic gross anatomical stucture, without making claims about brain function).  A path of ``sub-01/ses-test/func/sub-01_ses-test_task-overtverbgeneration_run-1_bold.nii.gz`` would indicate that the data in the file correspond to the participant ``01``, obtained within session ``test`` of a multi-sessionn scan, during the first run of a task named ``overtverbgeneration``. 

My conviction is that including metadata in a filename is better than nothing, and that there's certainly nothing wrong with using descriptive labels to aid researchers in their day-to-day lab work, but that relying upon filenames for metadata management and building software tooling that assumes a specific structure in a filename is an anti-pattern.  I have arrived at this conclusion through the following line of thought:

 * The primary goal of creating metadata for scientific data is to minimize the amount of information about an experiment that is lost and to make data more discoverable.
 * To minimize information loss, scientific metadata standards should be as robust to entropy as possible.
 * Robustness to entropy is a function of the level of complexity used to encode data (redundancy, etc).
 * The simplicity with which the operators used to encode metadata in filenames (file moves, file copies) within a computer operating system, and the ease with which someone could accidentally use these same operators to corrupt the metadata by changing a filename (thus leading to an increase in local entropy) makes information loss highly likely.
 * If metadata about a dataset is lost, its discoverability also decreases.

The flexibilty permitted by relying upon filenames for metadata poses other, potentially less philosophical problems.  From a technical standpoint, a large number of utilities and commercial products assume that filenames are encoded as ASCII text, and are painful to deal with if filenames are instead encoded with non-Latin characters in UTF-8. Similarly, a large number of Unix shell utilities privilege filenames without spaces.  In theory, a scientific metadata standard that wanted to rely upon filenames could prohibit UTF-8 characters and spaces in filenames, but it's not always clear from an end-user's perspective when some UTF-8 are used (i.e., for UTF-8 characters that look superficially identical to ASCII characters).
 
## Sidecar Files

With sidecar files, metadata about a file is stored in a serialized format like XML, JSON or YAML.  A relationship is established between the original file and its sidecar by having identical names save for the file extension.  A script or application can then easily read in both the original data and the metadata by stripping away the original file extension and checking for a corresponding file with the metadata format file extension instead.  Most often the metadata is stored as key-value pairs in an associative array, although this is true for most other methodologies of keeping metadata as well.
### Pros
 * Relatively flexible.  Easy to add metadata to a file without having to change a standard or use a metadata container format.
 * Simple and easy to use for end-users.  All that's required generally is a text editor.
 * Sidecar files are usually formatted using widely-adopted standards that are easy to parse with standard libraries (YAML, JSON, XML, etc).
### Cons
 * There's no way to enforce that the metadata stay with the source materials.  If the sidecar files and the files they describe are separated, you've lost your metadata or will end up with great descriptions but no data.
### Examples
 * [Gmvault](http://gmvault.org/) Database Metadata: Gmvault stores metadata related to Gmail features that aren't part of e-mail standards / RFCs in sidecar JSON files with the thread number followed by the file extension ".meta".  That way, when end-users restore e-mails to Gmail, Gmail-specific features like labels and threading are preserved.
 * [BIDS](http://bids.neuroimaging.io/): The BIDS standard uses sidecar JSONs to represent information about experimental parameters that are not represented in the [NifTI file format](https://brainder.org/2012/09/23/the-nifti-file-format/)headers. These parameters are often scan parameters that exist in metadata assoicated with [DICOM](http://book.orthanc-server.com/dicom-guide.html#dicom-file-format) files that is lost when the DICOMs are converted to NifTIs.
 * [EML](https://knb.ecoinformatics.org/#tools/eml) : EML, similar to BIDS is a scientific metadata format.  It uses XML sidecar files to describe ecological data.
 * [Kodi](https://kodi.wiki/view/NFO_files) : Kodi is a popular open source media player that uses an [XML sidecar](https://kodi.wiki/view/NFO_files) with the ".nfo" suffix to store metadata about T.V. shows and movies.  ".nfo" files can also be used to scrape online databases like IMDB or combine data scraped from online databases with user-added metadata that's stored locally.  This, in some ways, mirrors more advanced ways of managing metadata like FEDORA (see below).  The ".nfo" files of Kodi are not to be confused with the [".nfo" files of the warez scene](https://en.wikipedia.org/wiki/.nfo).

## Metadata Container Formats

Metadata container formats came about due to a desire to store descriptive metadata within the file itself, rather than as an external representation.  I

### Description

### Pros

 * Data and metadata are bound together in the same file, obviating concerns that either one could be lost (except through file corruption)

### Cons

 * Applications that interact with file formats need to have additional logic to deal with the metadata containers encapsulating those file formats.  Getting multiple application developers to agree to settle on a single standard file format is a task in and of itself- getting multiple application developers to support both a single file format and a single metadata container standard is nigh impossible.
 * Alternatively, if the metadata container only exists at the end of a file as a footer (as with earlier versions of ID3), an application must be willing robust to noise at the end of a file.

Examples:

 * ID3
 * Matroska (MKV)
 * [XMP](https://www.adobe.com/products/xmp.html) : XMP is a more recent metadata container format that has been enshrined in an ISO Standard (ISO 16684-1:2012 / ISO 16684-2:2014).  With XMP, essentially what you're doing is embedding XML at specific locations within a file type that are ideally safe to put unexpected data in.  The goal is to add metadata to arbitrary files like PDFs, JPGs or PNGs while still maintaining compatibility with tools that don't expect embedded metadata.  In some cases, there's no way around breakage, in which case it is suggested to store XMP metadata in a sidecar file (which negates the main advantage of using metadata container formats).

## Extended Attributes

Extended attributes are a seldom-used (by typical end-users at least) feature of some Linux and Mac OS X filesystems that allow you to arbitrarily add key-value tags to file metadata.

### Pros

 * Metadata is not separate from files.  If you move a file from one part of the filesystem to another, its metadata goes with it.

### Cons

 * Only some filesystems support extended attributes.  If you copy files with extended attributes to a filesystem (or broadly any other storage medium) that doesn't support them, they'll be removed.  For example, if I were to copy a number of files with extended attributes to a cloud-based object store like Amazon's S3, if I were to download them again at a later date to another desktop from S3 the extended attributes would be missing.  
 * The above con can be worked around if files with extended attributes are tarred and then untarred on another filesystem that supports extended attributes, but this still places a disproportionate amount of burden on an end-user and is error-prone.

## File Archives / Version Control Repositories

Examples:

 * BagIt
 * [Dataset Publishing Language](https://developers.google.com/public-data/) : DSPL is a standard for producing XML files to describe data contained within several CSV files.  It's primary focus is on facilitating data visualization.
 * DataLad / git-annex

## Using a Database or a Digital Asset Management (DAM) Tool

### Description

Other than developing one's own idiosyncratic system with MySQL, the only obvious example of a Digital Asset Management tool out there is Duraspace's Fedora.  Fedora is similar to the sidecar model in the sense that metadata and data can be stored in separate files ("datastreams" in Fedora parlance).  However, Fedora overcomes the central issue with sidecar files, which is that if they are separated from the data that they describe it can be difficult or impossible to reassociate them with their data.  Fedora gets around this by introducing a third file in FOXML, which describes a "digital object" - in particular this file directly establishes which metadata files are paired with which source files, which means that metadata and source files can live in totally different paths.  Newer versions of Fedora (Fedora 4) go even further in using an RDBMS instead of FOXML.

### Cons

 * The FOXML files need to be kept up to date through API calls to Fedora.  If some mischievous rascal gets access to your filesystem and decides to move files around, Fedora will lose track of them.
 * The terminology and heavy abstraction of Fedora can be confusing to newcomers, and has substantially less exposure outside the libraries community.

Examples:

 * Fedora Commons

## File Formats with Flexible Metadata Schemes

### Description

Some file formats allow for metadata to be flexibly added as part of the file format standard.  For these formats, no metadata container, sidecar files or additional archival formats are required, since metadata can be added as needed.

Examples:

 * [NetCDF](https://www.unidata.ucar.edu/software/netcdf/) (and by extension, [MINC](https://www.mcgill.ca/bic/software/minc))
 * [HDF5](https://support.hdfgroup.org/HDF5/)

## Conclusion

