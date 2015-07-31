init:
	mkdir -p storage
	touch storage/data.db
	php src/Api/console.php init
	php src/Api/console.php populate-test-data

web: .PHONY
	php -S localhost:8082 -t src/Api/web src/Api/web/dev.php

.PHONY: