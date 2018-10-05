---
layout: post
title:  "A Brief Overview of Methods for Adding Metadata to Files"
date:   2018-05-02 00:23:26
permalink: /metadata.html
---

*TODO*: Add discussion of https://bmcresnotes.biomedcentral.com/articles/10.1186/1756-0500-2-53

Note: This is a didactic post (i.e., I'm using this as an exercise to teach myself something), and is prone to updates (i.e., I'm probably full of inchoate nonsense on some points and will get schooled later).  For a full list of differences, see this post's Github history.

Recently, I converted a number of VHS / MiniDV home movies to MPEG-4s on a hard drive, primarily due to my apprehensions about the fallibility of tape media in the long-term, but also because VHS tapes a) take up too much space and b) aren't as portable as a thumb drive / external HD.  After finally finishing up the arduous procedure I used (perhaps a topic for another post), I discovered a new challenge.  While some of the tapes had timestamps overlayed on the footage, the files themselves did not contain this information.  It was now up to me to make sense of all these priceless home videos by generating some form descriptive and structural metadata for them so that generations of future relatives could enjoy all of my elementary school choir concerts.  But what exactly was the best way to approach this problem?

In my previous life as a neuroscience research assistant, I worked with an actively-developed data organization standard known as the [Brain Imaging Data Structure](http://bids.neuroimaging.io/) (BIDS).  Due to my experience working with BIDS, I became increasingly interested in methdologies used for capturing metadata related to scientific experiments and making datasets more discoverable, which ultimately evolved into a more generalized interest in metadata management.  The following is a summary of the methods I've come across, in part based on this [reddit post on r/datahoarder](https://www.reddit.com/r/DataHoarder/comments/7sqq7g/metadata_container_standard_for_arbitrary_files/) (and [this one](https://www.reddit.com/r/DataHoarder/comments/7jz2da/metadatatags_for_video_material/) as well), as well as my experiences working in an academic library.

## Sidecar Files
### Description
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

So- how am I planning on recording and storing metadata about my old family videos?  I'm not entirely sure yet, although for now I'm sticking with a plain old CSV file, which I can pretty readily parse with a Python script and convert to sidecar files or use a library like the [Python XMP Toolkit](https://python-xmp-toolkit.readthedocs.io) to embed the metadata.  FEDORA is likely out of the question since it requires a lot of overhead and I don't require complex modeling of arbitrary types of data, and git-annex could be interesting, but I don't plan on copying individual parts of the collection to separate volumes in a way that would lend itself to decentralized tooling (although I can always tack it on later).

One thing is for certain, however: I'd like to make sure that I can include video annotations in my metadata somehow, similar to how the Praat [TextGrid](http://www.fon.hum.uva.nl/praat/manual/Intro_7__Annotation.html) format works.  This is because such fine-grained annotations make life events more discoverable for future reflection.  Or perhaps the my convesion process just didn't do a good job at breaking some videos out into separate chapters :)
