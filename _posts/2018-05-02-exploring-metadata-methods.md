---
layout: post
title:  "A Prescriptive Taxonomy of Methods for Adding Metadata to Files"
date:   2018-05-02 00:23:26
permalink: /metadata.html
---

*TODO*: Add discussion of https://bmcresnotes.biomedcentral.com/articles/10.1186/1756-0500-2-53
https://5stardata.info/en/

In my previous life as a neuroscience research assistant, I worked with on the development of a data organization standard known as the [Brain Imaging Data Structure](http://bids.neuroimaging.io/) (BIDS).  Due to my experience working with BIDS, I became increasingly interested in methdologies used for capturing metadata related to scientific experiments and making datasets more discoverable.  This evolved into a more generalized interest in metadata management for digital formats.  The following is a summary of the methods I've come across, in part based on this [reddit post on r/datahoarder](https://www.reddit.com/r/DataHoarder/comments/7sqq7g/metadata_container_standard_for_arbitrary_files/) (and [this one](https://www.reddit.com/r/DataHoarder/comments/7jz2da/metadatatags_for_video_material/) as well), as well as my experiences working in an academic library.  It is opinionated and thus I have come to classify it as a "prescriptive taxonomy".
Not all of these opinions are 100% justified, and I aim to revisit this topic repeatedl, possibly revising this post multiple times in the future.

I approach this topic from the perspective of a former research assistant turned IT professional, and is such it is very library/science-centric.  I've begun by separating the methods of adding metadata I've seen into two broad categories.  I refer to metadata as being "loosely-coupled" if the metadata is contained in a data source that is external to the data itself.  "Tightly-coupled" metadata is metadata that exists within a data file itself, either as part of a file format specification or via a container format.

## Loosely-Coupled Metadata

### Metadata Encoded in Filenames

Many librarians specializing in data management will advise researchers to use descriptive filenames for their research ([see here](https://library.stanford.edu/research/data-management-services/data-best-practices/best-practices-file-naming)).  In neuroimaging, the BIDS standard enforces the inclusion of metadata in the filename and directory structure by means of a number of key/value pairs separated by underscores, ending with the type of scan used.  For instance, a filename of *sub-control01_T1w.nii.gz* would indicate that the data within the file belongs to a participant (subject) designated *control01* and that the kind of scan used is a T1w scan (these are used to provide high fidelity images of basic gross anatomical stucture, without making claims about brain function).  A path of *sub-01/ses-test/func/sub-01_ses-test_task-overtverbgeneration_run-1_bold.nii.gz* would indicate that the data in the file correspond to the participant *01*, obtained within session *test* of a multi-session scan, during the first run of a task named *overtverbgeneration*. 

#### Pros
 * It's relatively simple to encode experiment data in filenames, since it involves regular filesystem operations like moves and renames that pretty much anyone using a computer should be fluent in.  This makes this metadata encoding methodology incredibly easy to adopt, since the barrier to entry is low.
 * Useful for scientists in their day-to-day work as a way to describe what they're working with.

#### Cons
 * The extreme ease with which filesystem operations can be effected also makes information loss more likely- filenames are not as robust to entropy.
 * Relying upon tooling that assumes a specific filesystem structure is an anti-pattern unless that filesystem structure is protected from human error and/or has extremely robust error-handling.
 * From a technical standpoint, a large number of utilities and commercial products assume that filenames are encoded as ASCII text, and are painful to deal with if filenames are instead encoded with non-Latin characters in UTF-8. Similarly, a large number of Unix shell utilities privilege filenames without spaces.  In theory, a scientific metadata standard that wanted to rely upon filenames could prohibit UTF-8 characters and spaces in filenames, but it's not always clear at a glance when some UTF-8 characters are used (i.e., for UTF-8 characters that look superficially identical to ASCII characters).
 * Historically, cloud storage such as S3 benefitted from randomized file-naming (see [here](https://stackoverflow.com/questions/9648255/amazon-s3-partitioning-of-files-best-practices://aws.amazon.com/blogs/aws/amazon-s3-performance-tips-tricks-seattle-hiring-event/)).  Although this is no longer the case as of [July 2018](https://aws.amazon.com/about-aws/whats-new/2018/07/amazon-s3-announces-increased-request-rate-performance/), descriptive filenames/prefixes were penalized for a while in terms of S3 performance.
 * The latter two points underscore a more critical underlying point, which is that the treatment of filenames is, even still today, heavily dependent upon the implementation of the filesystem you're working on.  Since filesystems aren't designed with the same sets of [guarantees](https://en.wikipedia.org/wiki/ACID_(computer_science)) as databases, there is some peril in using them for purposes beyond the scope of their core functionality.

#### Examples

 * [BIDS](http://bids.neuroimaging.io/)
 * [Brainstorm](https://neuroimage.usc.edu/brainstorm/Tutorials/BstFolders)
 
### Sidecar Files

With sidecar files, metadata about a file is stored in a serialized format like XML, JSON or YAML.  A relationship is established between the original file and its sidecar by having identical names save for the file extension.  A script or application can then easily read in both the original data and the metadata by stripping away the original file extension and checking for a corresponding file with the metadata format file extension instead.  Most often the metadata is stored as key-value pairs in an associative array, although this is true for most other methodologies of keeping metadata as well.

#### Pros

 * Relatively flexible.  Easy to add metadata to a file without having to change a standard or use a metadata container format.
 * Simple and easy to use for end-users.  All that's required generally is a text editor.
 * Sidecar files are usually formatted using widely-adopted standards that are easy to parse with standard libraries (YAML, JSON, XML, etc).

#### Cons

 * There's no way to enforce that the metadata stay with the source materials.  If the sidecar files and the files they describe are separated, you've lost your metadata or will end up with great descriptions but no data.

#### Examples

 * [Gmvault](http://gmvault.org/) Database Metadata: Gmvault stores metadata related to Gmail features that aren't part of e-mail standards / RFCs in sidecar JSON files with the thread number followed by the file extension ".meta".  That way, when end-users restore e-mails to Gmail, Gmail-specific features like labels and threading are preserved.
 * [BIDS](http://bids.neuroimaging.io/): The BIDS standard uses sidecar JSONs to represent information about experimental parameters that are not represented in the [NifTI file format](https://brainder.org/2012/09/23/the-nifti-file-format/)headers. These parameters are often scan parameters that exist in metadata assoicated with [DICOM](http://book.orthanc-server.com/dicom-guide.html#dicom-file-format) files that is lost when the DICOMs are converted to NifTIs.
 * [EML](https://knb.ecoinformatics.org/#tools/eml) : EML, similar to BIDS is a scientific metadata format.  It uses XML sidecar files to describe ecological data.
 * [Kodi](https://kodi.wiki/view/NFO_files) : Kodi is a popular open source media player that uses an [XML sidecar](https://kodi.wiki/view/NFO_files) with the ".nfo" suffix to store metadata about T.V. shows and movies.  ".nfo" files can also be used to scrape online databases like IMDB or combine data scraped from online databases with user-added metadata that's stored locally.  This, in some ways, mirrors more advanced ways of managing metadata like FEDORA (see below).  The ".nfo" files of Kodi are not to be confused with the [".nfo" files of the warez scene](https://en.wikipedia.org/wiki/.nfo).
 * [Frictionless Data](https://frictionlessdata.io)

## Using a Database or a Digital Asset Management (DAM) Tool

### Description

Other than developing one's own idiosyncratic system with MySQL, the only obvious example of a Digital Asset Management tool out there is Duraspace's Fedora.  Fedora is similar to the sidecar model in the sense that metadata and data can be stored in separate files ("datastreams" in Fedora parlance).  However, Fedora overcomes the central issue with sidecar files, which is that if they are separated from the data that they describe it can be difficult or impossible to reassociate them with their data.  Fedora gets around this by introducing a third file in FOXML, which describes a "digital object" - in particular this file directly establishes which metadata files are paired with which source files, which means that metadata and source files can live in totally different paths.  Newer versions of Fedora (Fedora 4) go even further in using an RDBMS instead of FOXML.

### Cons

 * The FOXML files need to be kept up to date through API calls to Fedora.  If some mischievous rascal gets access to your filesystem and decides to move files around, Fedora will lose track of them.
 * The terminology and heavy abstraction of Fedora can be confusing to newcomers, and has substantially less exposure outside the libraries community.

Examples:

 * Fedora Commons

## Tightly-Coupled Metadata

### Metadata Container Formats

Metadata container formats came about due to a desire to store descriptive metadata within the file itself, rather than as an external representation.  I

#### Pros

 * Data and metadata are bound together in the same file, obviating concerns that either one could be lost (except through file corruption)

#### Cons

 * Applications that interact with file formats need to have additional logic to deal with the metadata containers encapsulating those file formats.  Getting multiple application developers to agree to settle on a single standard file format is a task in and of itself- getting multiple application developers to support both a single file format and a single metadata container standard is nigh impossible.
 * Alternatively, if the metadata container only exists at the end of a file as a footer (as with earlier versions of ID3), an application must be willing robust to noise at the end of a file.

#### Examples

 * ID3
 * Matroska (MKV)
 * [XMP](https://www.adobe.com/products/xmp.html) : XMP is a more recent metadata container format that has been enshrined in an ISO Standard (ISO 16684-1:2012 / ISO 16684-2:2014).  With XMP, essentially what you're doing is embedding XML at specific locations within a file type that are ideally safe to put unexpected data in.  The goal is to add metadata to arbitrary files like PDFs, JPGs or PNGs while still maintaining compatibility with tools that don't expect embedded metadata.  In some cases, there's no way around breakage, in which case it is suggested to store XMP metadata in a sidecar file (which negates the main advantage of using metadata container formats).

### Extended Attributes

Extended attributes are a seldom-used (by typical end-users at least) feature of some Linux and Mac OS X filesystems that allow you to arbitrarily add key-value tags to file metadata.

#### Pros

 * Metadata is not separate from files.  If you move a file from one part of the filesystem to another, its metadata goes with it.

#### Cons

 * Only some filesystems support extended attributes.  If you copy files with extended attributes to a filesystem (or broadly any other storage medium) that doesn't support them, they'll be removed.  For example, if I were to copy a number of files with extended attributes to a cloud-based object store like Amazon's S3, if I were to download them again at a later date to another desktop from S3 the extended attributes would be missing.  
 * The above con can be worked around if files with extended attributes are tarred and then untarred on another filesystem that supports extended attributes, but this still places a disproportionate amount of burden on an end-user and is error-prone.

### File Archives / Version Control Repositories

#### Examples

 * BagIt
 * [Dataset Publishing Language](https://developers.google.com/public-data/) : DSPL is a standard for producing XML files to describe data contained within several CSV files.  It's primary focus is on facilitating data visualization.
 * DataLad / git-annex

## File Formats with Flexible Metadata Schemes

### Description

Some file formats allow for metadata to be flexibly added as part of the file format standard.  For these formats, no metadata container, sidecar files or additional archival formats are required, since metadata can be added as needed.

Examples:

 * [NetCDF](https://www.unidata.ucar.edu/software/netcdf/) (and by extension, [MINC](https://www.mcgill.ca/bic/software/minc))
 * [HDF5](https://support.hdfgroup.org/HDF5/)

## Conclusion

