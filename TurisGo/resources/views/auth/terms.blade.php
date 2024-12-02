<html lang="{{ app()->getLocale() }}">

<!-- terms_modal.php -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <h2>{{ __('Terms and Conditions') }}</h2>
        <p><strong>1. {{ __('Acceptance of Terms') }}</strong><br>{{ __('By creating an account on TurisGo, you accept and agree to the following Terms and Conditions. These terms outline the rights and responsibilities of users and TurisGo.') }}</p>
        <p><strong>2. {{ __('Use of the Platform') }}</strong><br>{{ __('TurisGo is a platform designed to facilitate the search, comparison, and booking of hotels, activities, and tour packages. You agree to use the platform for personal, non-commercial purposes only.') }}</p>
        <p><strong>3. {{ __('Information Accuracy') }}</strong><br>{{ __('TurisGo strives to provide accurate and up-to-date information on hotels, activities, prices, and availability. However, we are not liable for any changes or inaccuracies in data provided by third-party sources, such as external APIs.') }}</p>
        <p><strong>4. {{ __('Cancellations and Refunds') }}</strong><br>{{ __('Cancellation and refund policies may vary depending on the type of reservation or service. Users should check specific details for each booking to understand cancellation terms and any applicable refunds.') }}</p>
        <p><strong>5. {{ __('Privacy and Data Protection') }}</strong><br>{{ __('TurisGo is committed to protecting user privacy in compliance with data protection laws. Personal data will be used solely for platform operations and will not be shared with third parties without consent.') }}</p>
        <p><strong>6. {{ __('Modification of Terms') }}</strong><br>{{ __('TurisGo reserves the right to modify these Terms and Conditions at any time. Any changes will be notified to users, and continued use of the platform implies acceptance of the revised terms.') }}</p>
        <p><strong>7. {{ __('Acceptance') }}</strong><br>{{ __('By clicking "I Accept the Terms and Conditions," you confirm that you have read, understood, and agree to comply with all the Terms and Conditions outlined above.') }}</p>
        <button id="closeModal">{{ __('Close') }}</button>
    </div>
</div>
