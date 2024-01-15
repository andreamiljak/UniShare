
const SendMsg = document.getElementById('send_msg');
SendMsg.addEventListener('click', handleSendMsgClick);


// Function to fetch and display data from the server
function fetchData() {
    // Make an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'dohvati_poruke.php', true);

    // Set the callback function
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
			// Parse the JSON response
			var korisnicko_ime = JSON.parse(xhr.responseText).korisnicko_ime;
			var data = JSON.parse(xhr.responseText).data;
			console.log('Session Username:', korisnicko_ime);
			// Process the data and display it
			ispisiPoruke(data, korisnicko_ime);
        }
    };

    // Send the request
    xhr.send();
}

// Function to display data on the webpage
function ispisiPoruke(data, korisnicko_ime) {
    // Get the element where you want to display the data
    var displayElement = document.getElementById('received-chats');

    // Loop through the data and print each row
    data.forEach(function (row) {
        // Create an object for each row
        var dolazecaPoruka = {
            korisnicko_ime: row.korisnicko_ime,
            poruka: row.poruka,
            vrijeme: row.vrijeme
		};
		if (korisnicko_ime == dolazecaPoruka.korisnicko_ime) {

			const msgTemplate = document.getElementById('msg-template');
			const msgNode = document.importNode(msgTemplate.content, true);
			const msgElement = msgNode.querySelector('.msg');

			const currentDateTime = dolazecaPoruka.vrijeme;

			const msgTime = document.createElement('span');
			msgTime.innerText = currentDateTime;
			msgTime.setAttribute('class', 'time');
			msgElement.querySelector('.outgoing-msg').appendChild(msgTime);

			const msgParagraph = document.createElement('p');
			msgParagraph.innerText = dolazecaPoruka.poruka;
			msgElement.querySelector('.outgoing-chats-msg').appendChild(msgParagraph);

			const msgContainer = document.createElement('div');
			msgContainer.setAttribute('class', 'outgoing-chats');
			msgContainer.appendChild(msgElement);

			//const msgContainer = document.getElementById('outgoing-chats');
			//msgContainer.appendChild(msgElement);

			const msgPage = document.getElementById('msg-page');
			msgPage.appendChild(msgContainer);
			
		}

		else {
			
			const r_msgTemplate = document.getElementById('recieved-msg-template');
			const r_msgNode = document.importNode(r_msgTemplate.content, true);
			const r_msgElement = r_msgNode.querySelector('.msg');

			const currentDateTime = dolazecaPoruka.vrijeme;

			const r_msgTime = document.createElement('span');
			r_msgTime.innerText = currentDateTime;
			r_msgTime.setAttribute('class', 'time');
			r_msgElement.querySelector('.received-msg').appendChild(r_msgTime);

			const r_msgParagraph = document.createElement('p');
			r_msgParagraph.innerText = dolazecaPoruka.poruka;
			r_msgElement.querySelector('.received-msg-inbox').appendChild(r_msgParagraph);

			const r_msgContainer = document.createElement('div');
			r_msgContainer.setAttribute('class', 'received-chats');
			r_msgContainer.appendChild(r_msgElement);
			//const r_msgContainer = document.getElementById('received-chats');
			//r_msgContainer.appendChild(r_msgElement);

			const msgPage = document.getElementById('msg-page');
			msgPage.appendChild(r_msgContainer);
		}
		


    });
}

// Call the fetchData function when the page loads
window.onload = fetchData;


function handleSendMsgClick() {
		
		const msgTxt = document.getElementById('msg_text').value;
		//const title = prompt(`'${msgTxt}'`, 'Default title');
		const msgTemplate = document.getElementById('msg-template');
		const msgNode = document.importNode(msgTemplate.content, true);
		const msgElement = msgNode.querySelector('.msg');
	

		//msgElement.setAttribute('card-id', cardId);
		//msgElement.setAttribute('user-id', userId);
		const now = new Date();
		// get the current date and time as a string
		const currentDateTime = now.toLocaleString();

		
		const msgTime = document.createElement('span');
		msgTime.innerText = currentDateTime;
		msgTime.setAttribute('class', 'time');
		msgElement.querySelector('.outgoing-msg').appendChild(msgTime);

		const msgParagraph = document.createElement('p');
		msgParagraph.innerText = msgTxt;
		msgElement.querySelector('.outgoing-chats-msg').appendChild(msgParagraph);

		const msgContainer = document.getElementById('outgoing-chats');
		msgContainer.appendChild(msgElement);


	


}

