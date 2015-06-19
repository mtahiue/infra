build:
	docker build -t kinoulink/share .

run:
	docker run -d -ti -p 139:139 -p 138:138 -p 445:445 --name=dev_share kinoulink/share

destroy:
	docker rm -f dev_share