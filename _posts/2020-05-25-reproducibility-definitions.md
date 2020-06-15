---
layout: post
title:  "The National Academies of Science and Engineering and ACM Definitions of Reproducibility"
date:   2020-05-25 13:36:14
permalink: /reproducibility-definitions.html
---

In November of last year, I attended the [SC19](https://sc19.supercomputing.org/) conference, which brings together an assortment of computer scientists, systems administrators, and vendors.  One of the various birds of a feather sessions I attended ([The National Academies’ Report on Reproducibility and Replicability in Science: Inspirations for the SC Reproducibility Initiative](https://sc19.supercomputing.org/session/?sess=sess293)) discussed the issue of reproducibility in great detail.  The big news at this session was that several [operationalizations](https://en.wikipedia.org/wiki/Operationalization) for the concept of reproducibility that were developed independently by the ACM (see [here](https://www.acm.org/publications/policies/artifact-review-badging)) and the National Academies (see [here](https://doi.org/c5jp)) were being harmonized across the two organizations.

A primary motivation for this reconciliation of jargon was that the ACM and National Academies were, in fact, using the same words to refer to the nearly the exact opposite concepts.  Namely, the ACM defined the term **replicability** to mean an attempt to reproduce an article's results using the exact same experimental setup by another team, while the term **reproducibility** indicated the concept of convergent results made by a different team using a different experimental setup.  

The National Academies, in contrast, defined **reproducibility** as the act of an independent team obtaining the same results through rigid adherence to the same methods and setup while also using the same dataset, while **replicability** referred to convergent results emerging from non-identical setups.

My personal take on this news is that the original operationalizations used by both the ACM and the National Academies are both flawed, not by dint of their actual definitions, but in the manner that they have been formulated.  Both sets of definitions treat varying degrees of reproducibility as belonging to discrete categories, whereas I think that a better characterization of reproducibility would be to think of it as a continuous spectrum.  Very rarely are replication attempts as black or white as to be binned into one or two categories, and by trying to lump studies together in this way valuable details about how a replication was performed could be lost.

It is my personal opinion that it would be better to use one term (reproducibility) consistently, and maybe treat other terms such "replicability" as redundant aliases for the main term, and then to characterize reproducibility as being composed of several continuous features (such as similarity between measurement apparatuses or computing environments) that can be reported alongside a replication attempt.
