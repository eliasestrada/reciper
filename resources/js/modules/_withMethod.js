export default method => {
    return {
        method: method,
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _token: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        })
    };
};
