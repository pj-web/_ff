let orderData = {
    real_price: '67.00', // Novaja cena
    old_price: '134', // Staraja cena

    currencySign: 'UAH', // Znak valjuty: 'rub.'

    city: '', // Gorod

    offer_id: '40', // 1
    user_id: '39', // 877
    country: 'UA', // 'UA'
    api_key: '8f2ca5b14b07d353b224f2e0063eac66', // 0fccf538fa0311906f0c32fsfsdf7667sdf
    check_sum: '',
    web_id: 0,
    ip: '',

    name: '', // 'VasjaPupkin'
    phone: '', // '123456789'

    agent: '', // 'Opera'

    data1: '',
    data2: '',
    data3: '',
    data4: '',
    data5: '',

    utm_source: '',
    utm_content: '',
    utm_campaign: '',
    utm_term: '',

    targetTnxUrl: 'index-sps.html'
};

// Spisok UTM metok kotorye avtomatom budut probrasyvat'sja pri zakaze
const utm = [
    'utm_source',
    'utm_content',
    'utm_campaign',
    'utm_term',
    'data1',
    'data2',
    'data3',
    'data4',
    'data5',
];

const thisURL = new URL(window.location);
utm.forEach(i => orderData[i] = thisURL.searchParams.get(i) ? thisURL.searchParams.get(i) : orderData[i]);

window.orderData = orderData;
window.utm_forward = utm;


window.jQuery = $;
window.$ = $;
window.jquery = $;
