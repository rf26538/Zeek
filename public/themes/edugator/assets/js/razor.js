$(function() {

    $('#payButton').click(function(event) {
        event.preventDefault();
        var amount = $('#amount').val();
        var amount = $('#amount').val();
    
        var options = {
            key: 'YOUR_RAZERPAY_KEY', 
            amount: amount * 100,
            currency: 'INR',
            name: 'Your Company Name',
            description: 'Payment for Service',
            handler: function (response) {
                console.log(response);
                alert('Payment successful');
            },
            prefill: {
                name: 'Your Name',
                email: 'your_email@example.com',
                contact: '1234567890'
            },
            notes: {
                address: 'Your Address'
            },
            theme: {
                color: '#3399cc'
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    });
});