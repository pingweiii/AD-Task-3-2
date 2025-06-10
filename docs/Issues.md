# Port Issue in Docker
## Option 1
1. Open `compose.yml`
2. Update the first port(external port) in all services or problematic service
```yml
ports:
    # <expose port>:<internal port>
    # Problematic
    - "8000:8000"

    # Updated
    - "8080:8000"
```
3. rerun `compose up`

## Option 2
1. Open docker desktop
2. find the port that is open
3. close it
4. rerun `compose up`