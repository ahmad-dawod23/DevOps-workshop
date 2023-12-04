FROM python:3.10

RUN apt-get update 

COPY . /python-flask

WORKDIR /python-flask

RUN pip install -r requirements.txt

ENTRYPOINT [ "python" ]

EXPOSE 5000

CMD [ "app.py" ]