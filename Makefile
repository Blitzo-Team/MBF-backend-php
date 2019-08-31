deploy-staging:
	ssh ubuntu@staging.acctechnology.ph '\
	cd npo/npo-backend-users; pwd;\
	git pull; \
	'

refresh-staging:
	ssh ubuntu@staging.acctechnology.ph '\
	cd npo/npo-backend-users; pwd;\
	git pull; \
	php artisan migrate:refresh; \
	'

migrate-staging:
	ssh ubuntu@staging.acctechnology.ph '\
	cd npo/npo-backend-users; pwd;\
	git pull; \
	php artisan migrate; \
	'

rollback-staging:
	ssh ubuntu@staging.acctechnology.ph '\
	cd npo/npo-backend-users; pwd;\
	git pull; \
	php artisan migrate:rollback; \
	'

install-staging:
	ssh ubuntu@staging.acctechnology.ph '\
	cd npo/npo-backend-users; pwd;\
	git pull; \
	composer install; \
	'