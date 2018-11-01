---
layout: post
title:  "Meditations on the 'Archivability Crisis' in Science and the Long-Term Reproducibility of Scientific Analyses"
date:   2018-10-29 23:59:59
permalink: /scientific-archivability.html
---

This post is a brief, non-comprehensive response to C. Titus Brown's [How I learned to stop worrying and love the coming archivability crisis in scientific software](http://ivory.idyll.org/blog/2017-pof-software-archivability.html), informed both by [Emulation & Virtualization as Preservation Strategies](https://mellon.org/media/filer_public/0c/3e/0c3eee7d-4166-4ba6-a767-6b42e6a1c2a7/rosenthal-emulation-2015.pdf) by David S. H. Rosenthal and past experiences attending [Vintage Computer Festival East](http://vcfed.org/wp/festivals/vintage-computer-festival-east/) in the lovely oceanside township of Wall Township, NJ.  

As always, the following disclaimer applies (as it does to all of my opinions): I could be full of [whoomp](https://www.youtube.com/watch?v=1Gmn-XFGZws).  

I intend to react to several of Brown's assertions.  Namely: 1) that you can't save all the software necessary to faithfully reproduce an analysis pipeline, 2) that containers, as black boxes, are bad for inspectability.
 
I'll start by putting my own biases out for inspection- I'm candidly a lot more bullish about the long-term viability of replicating scientific experiments *in silica* going forward, and my gut reaction to this post is that Brown's claim that we can't save *all* software, while superficially true in the sense that it would be near impossible to save the entire statistical population of all written software, is hyperbolic in the sense that the most popular scientific software stacks will be sufficiently preserved into the distant future.  Why do I think this?  Statistically, the more popular a scientific package is the more copies of it will be made, and the more likely it is to survive.  Essentially, I have confidence in a sort of digital Darwinism that will ensure that core packages essential to scientific analayses remain around for a while.

Beyond an evolutionary argument, modern software stacks have an advantage in the sense that most environments, whether they be Linux, BSD, or OS X (heck even [Windows](https://chocolatey.org/)) now have package managers.  So long as one mirrors the package manager repositories (or even just individual package files for dependencies) for all the applications and libraries used in an analysis, one can easily unpack pre-requisite software and re-create an environment for one's operating system of choice.  Prior to the development of [apt](https://en.wikipedia.org/wiki/APT_(Debian)) and [yum](https://en.wikipedia.org/wiki/Yum_(software)) in the late 90s, it is certainly true that software stacks are much harder to reproduce due to the homogeneity of software and hardware architectures and the inconsistency in how software was distributed.

Examples of people doing great things with package management: [NeuroFedora](https://fedoraproject.org/wiki/SIGs/NeuroFedora) and [NeuroDebian](http://neuro.debian.net/).

The preservation of scientific pipelines is much easier than other preservation strategies.  David Rosenthal makes the distinction between two types of fidelity in emulation: 

> Fidelity to the original is a concern. There are two types
> of fidelity to consider, execution fidelity, whether the emulation
> executes the program correctly, and experiential
> fidelity, how close a user’s experience is to the original
> user’s experience.

He then proceeds to note that due to Turing equivalence, any program should in theory be executable upon any other Turing equivalent machine:

> In a Turing sense all computers are equivalent to each
> other, so it is possible for an emulator to replicate the behavior
> of the target machine’s CPU and memory exactly,
> and most emulators do that. The only significant difference
> is in performance, and Moore’s Law has meant
> that current CPUs and memories are so much faster than
> the systems that ran legacy digital artefacts that they may
> need to be artificially slowed to make the emulation realistic.

Neither speed nor experiential fidelity or of particular utility with respect to scientific reproducibility.  

"But John," you say, "you've only really addressed software.  What about hardware elements in the stack underlying an in silica analysis?"

Well, as David Rosenthal points out in the article cited earlier (Rosenthal, section 3.2.4), the hardware underlying most software in general largely belongs to one of two CPU architectures (Intel/AMD x86_64 and ARM) due to market consolidation.

(i.e., a sufficiently large sample of the most commonly used software for analyses will be preserved), and executable upon emulation layers that are either also implemented in software or via FPGAs.

Examples of old architectures re-implemented using FPGAs:
http://www.cs.columbia.edu/~sedwards/apple2fpga/

Software:
https://www.cs.drexel.edu/~bls96/eniac/
https://hackaday.com/2018/05/24/vcf-east-the-desktop-eniac/#more-308966

In the past, it used to be common to have multiple hardware architectures running on a single machine, as showcased in the exhibit "Microcomputers With an Identity Crisis" by Douglas Crawford, Chris Fala, and Todd George.  I see no reason why hardware architectures can't be as fluid now as back in the 80s and 90s, and why we should act as though there isn't flexibility in trying to replicate an analysis from long ago.


Basically, yes Docker is black box and that could be a bad thing.  You really need configuration management (which promotes Yolanda Gil's inspectability) with hardcoded version numbers to document your server setup, good software packaging practices (which make software stacks less brittle and software archivability easier to manage), and well-documented workflows (my ideal would be to use an easy to use format like CWL).

The issue with Docker also is that containerization is not sufficiently standardized across POSIX platforms.  If there's a mass exodus from Linux to illumos at some point, for example, the containerization solution would become a solaris zone.

Another point in this whole conversation about reproducibility, however, is how far we want to go with reproducing results.  Up until now, we've focused on talking about reproducing the CPU instructions / program that performs an analysis, but what about the data?  There's another fidelity at play here, instrumentation fidelity.  Are we going to re-create the exact same MRI machine or electron microscope to validate results in the future?  Many designs are proprietary in life sciences.  What if there are systematic flaws in data collection that affect an entire generation of analyses that we don't know about.
