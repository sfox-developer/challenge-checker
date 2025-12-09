<x-public-layout>
    <x-slot name="title">Imprint - {{ config('app.name') }}</x-slot>
    
    <div class="static-page-container">
        <div class="static-page-header">
            <div class="static-page-icon">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <h1 class="static-page-title">Imprint</h1>
                <p class="static-page-subtitle">Legal information and contact details</p>
            </div>
        </div>

        <div class="static-page-content">
            <section class="content-section">
                <h2 class="section-heading">Information according to § 5 TMG</h2>
                <div class="content-block">
                    <p><strong>{{ config('app.name') }}</strong></p>
                    <p>Your Company Name</p>
                    <p>Your Street Address</p>
                    <p>Your City, Postal Code</p>
                    <p>Country</p>
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-heading">Contact</h2>
                <div class="content-block">
                    <p>Email: contact@example.com</p>
                    <p>Phone: +1 (555) 123-4567</p>
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-heading">Responsible for content</h2>
                <div class="content-block">
                    <p>Your Name</p>
                    <p>Your Street Address</p>
                    <p>Your City, Postal Code</p>
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-heading">Dispute resolution</h2>
                <div class="content-block">
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

            <section class="content-section">
                <h2 class="section-heading">Liability for content</h2>
                <div class="content-block">
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

            <section class="content-section">
                <h2 class="section-heading">Liability for links</h2>
                <div class="content-block">
                    <p>
                        Our website contains links to external third-party websites over whose content we have no influence. 
                        Therefore, we cannot assume any liability for this third-party content. The respective provider or operator 
                        of the pages is always responsible for the content of the linked pages.
                    </p>
                </div>
            </section>

            <section class="content-section">
                <h2 class="section-heading">Copyright</h2>
                <div class="content-block">
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
