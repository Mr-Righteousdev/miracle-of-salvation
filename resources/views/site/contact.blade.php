@extends('layouts.site')

@section('title', 'Contact Us')

@section('content')

<section class="contact-hero">
    <div class="contact-hero-content">
        <span>WE WOULD LOVE TO HEAR FROM YOU</span>
        <h1>Contact Us</h1>
        <p>Connect with Miracle of Salvation Church. We are here to pray with you, support you and welcome you.</p>
    </div>
</section>

<section class="contact-section">

    <div class="contact-intro">
        <h2>Get in Touch</h2>
        <p>
            Whether you have a question, need prayer, want to visit our church
            or would like to learn more about our ministry, please reach out.
        </p>
    </div>

    <div class="contact-layout">

        <div class="contact-information">
            <h3>Contact Information</h3>

            <div class="contact-info-item">
                <div class="contact-icon">⌖</div>
                <div>
                    <h4>Our Church</h4>
                    <p>Miracle of Salvation Church</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">⌂</div>
                <div>
                    <h4>Postal Address</h4>
                    <p>P.O. Box 30501, Kampala, Uganda</p>
                </div>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">♡</div>
                <div>
                    <h4>Prayer and Support</h4>
                    <p>Reach out to us for prayer and spiritual support.</p>
                </div>
            </div>

            <div class="contact-quote">
                "For where two or three gather in my name, there am I with them."
                <strong>Matthew 18:20</strong>
            </div>
        </div>

        <div class="contact-form-container">
            <h3>Send Us a Message</h3>
            <p>Fill in the form below and share your message with us.</p>

            <livewire:contact-form />
        </div>

    </div>
</section>
@endsection
