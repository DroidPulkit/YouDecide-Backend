This is the backend which is basically API made to serve the YouDecide Survey app.
We deployed this backend in digitalocean droplet under the LAMP stack in Ubuntu 14.04.
To run this backend you will need to install "composer" and install "PHPMailer" for the app to automatically send the QR codes when the app finishes generating the survey.
Make sure to chmod 777 the users directory so that php can make folders while making a user.
We follow the following structure when new user is registered on our app:- 
When the user registers the username folder gets created in the user folder, and all the surveys have there respective folders inside the corresponding username folder.
In the survey folder we make the question.json file and answer.txt file and QR code image is saved there.
