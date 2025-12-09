<x-public-layout>
    <x-slot name="title">Imprint - {{ config('app.name') }}</x-slot>
    
    <div class="section">
        <div class="container max-w-3xl">
            
            <h1 class="h1 opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                x-data="{}" 
                x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 100)">Imprint</h1>
            <p class="subtitle mb-10 opacity-0 translate-y-8 transition-all duration-700 ease-out" 
               x-data="{}" 
               x-init="setTimeout(() => { $el.classList.remove('opacity-0', 'translate-y-8') }, 200)">Legal information</p>

            <div class="space-y-10">
            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Information according to § 5 TMG</h2>
                <div class="space-y-1 text-body">
                    <p><strong>{{ config('app.name') }}</strong></p>
                    <p>Your Company Name</p>
                    <p>Your Street Address</p>
                    <p>Your City, Postal Code</p>
                    <p>Country</p>
                </div>
            </section>

            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Contact</h2>
                <div class="space-y-1 text-body">
                    <p>Email: contact@example.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
                </div>
            </section>

            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Responsible for content</h2>
                <div class="space-y-1 text-body">
                    <p>Your Name</p>
                    <p>Your Street Address</p>
                    <p>Your City, Postal Code</p>
                </div>
            </section>

            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Dispute resolution</h2>
                <div class="space-y-3 text-body">
                    <p>
                        The European Commission provides a platform for online dispute resolution (OS): 
                        <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener noreferrer" class="text-link">
                            https://ec.europa.eu/consumers/odr
                        </a>
                    </p>
                    <p>
                        We are not willing or obliged to participate in dispute resolution proceedings before a consumer arbitration board.
                    </p>
                </div>
            </section>

            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Liability for content</h2>
                <div>
                    <p>
                        As a service provider, we are responsible for our own content on these pages in accordance with general legislation. 
                        However, we are not obliged to monitor transmitted or stored third-party information or to investigate circumstances 
                        that indicate illegal activity.
                    </p>
                    <p>
                        Obligations to remove or block the use of information under general legislation remain unaffected. 
                        However, liability in this regard is only possible from the time of knowledge of a specific legal violation. 
                        If we become aware of such legal violations, we will remove this content immediately.
                    </p>
                </div>
            </section>

            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Liability for links</h2>
                <div>
                    <p>
                        Our website contains links to external third-party websites over whose content we have no influence. 
                        Therefore, we cannot assume any liability for this third-party content. The respective provider or operator 
                        of the pages is always responsible for the content of the linked pages.
                    </p>
                </div>
            </section>

            <section class="opacity-0 translate-y-8 transition-all duration-700 ease-out" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('opacity-0', 'translate-y-8')">
                <h2 class="h2">Copyright</h2>
                <div>
                    <p>
                        The content and works on these pages created by the site operators are subject to copyright law. 
                        The reproduction, editing, distribution and any kind of use outside the limits of copyright require 
                        the written consent of the respective author or creator.
                    </p>
                </div>
            </section>
        </div>
    </div>
</x-public-layout>
