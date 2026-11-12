<div>
    @if (session('contact_message_sent'))
        <div class="form-success">
            Thank you for contacting Miracle of Salvation Church.
            Your message has been received and we will get back to you.
        </div>
    @endif

    @if ($errors->any())
        <div class="form-error">
            Please complete all fields using a valid email address.
        </div>
    @endif

    <form wire:submit="submit">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" wire:model="name"
                   placeholder="Enter your full name" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" wire:model="email"
                   placeholder="Enter your email address" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" id="subject" wire:model="subject"
                   placeholder="What is your message about?" required maxlength="255">
        </div>

        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea id="message" wire:model="message" rows="6"
                      placeholder="Write your message here..." required maxlength="5000"></textarea>
        </div>

        <button type="submit" class="contact-submit">
            SEND MESSAGE
        </button>
    </form>
</div>
