sudo apt-get install python-virtualenv
virtualenv -p python3 venv
. venv/bin/activate
pip install -U -r ../src/requirements.txt
pip install --editable .