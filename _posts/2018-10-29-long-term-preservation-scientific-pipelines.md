---
layout: post
title:  "Meditations on the 'Archivability Crisis' in Science and the Long-Term Reproducibility of Scientific Analyses"
date:   2018-10-29 23:59:59
permalink: /scientific-archivability.html
---

This post is a brief, non-comprehensive response to C. Titus Brown's [How I learned to stop worrying and love the coming archivability crisis in scientific software](http://ivory.idyll.org/blog/2017-pof-software-archivability.html), informed both by [Emulation & Virtualization as Preservation Strategies](https://mellon.org/media/filer_public/0c/3e/0c3eee7d-4166-4ba6-a767-6b42e6a1c2a7/rosenthal-emulation-2015.pdf) by David S. H. Rosenthal and past experiences attending [Vintage Computer Festival East](http://vcfed.org/wp/festivals/vintage-computer-festival-east/) in the lovely oceanside township of Wall Township, NJ.  The prose is not intended to be particularly glamorous or elegant and the ideas may not be fully developed, so do pardon (and feel free to point out) any egregious flaws in my reactions.  It is an essay in the original sense of the word, which is to say a mere "attempt" only at formulating a stimulating set of thoughts.

I'll start by putting my own biases out for inspection- I'm candidly a lot more bullish about the long-term viability of replicating scientific experiments going forward, and my gut reaction to this post is that Brown's claims that we can't save *all* software, while superficially true in the sense that it would be near impossible to save the entire population [1] of all written software, are hyperbolic in the sense that most software stacks will be sufficiently preserved into the distant future, and executable upon emulation layers that are either also implemented in software or via FPGAs.

Examples of old architectures re-implemented using FPGAs:
http://www.cs.columbia.edu/~sedwards/apple2fpga/

Software:
https://www.cs.drexel.edu/~bls96/eniac/
https://hackaday.com/2018/05/24/vcf-east-the-desktop-eniac/#more-308966

In the past, it used to be common to have multiple hardware architectures running on a single machine, as showcased in the exhibit "Microcomputers With an Identity Crisis" by Douglas Crawford, Chris Fala, and Todd George.  I see no reason why hardware architectures can't be as fluid now as back in the 80s and 90s, and why we should act as though there isn't flexibility in trying to replicate an analysis from long ago.

To delve into more detail on this I'd like to cite 

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

Neither speed nor experiential fidelity or of particular utility with respect to scientific reproducibility.  Rosenthal also notes the trend towards architectural consolidation, with only two major hardware architectures really being used in practice in modern computing:

> Although it is
> impressive that MESS emulates nearly two thousand different
> systems from the past, going forward emulating
> only two architectures (Intel and ARM) will capture the
> overwhelming majority of digital artefacts.

Basically, yes Docker is black box and that could be a bad thing.  You really need configuration management (which promotes Yolanda Gil's inspectability) with hardcoded version numbers to document your server setup, good software packaging practices (which make software stacks less brittle and software archivability easier to manage), and well-documented workflows (my ideal would be to use an easy to use format like CWL).


[1] By the definition of modern statistics
