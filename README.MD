# HOW TO USE IT

## Set execution permission to the scripts in the folder if needed

### `sudo chmod +x -R scripts`

## Build the docker image

inside this folder 

### `docker build -t mytest .`

## run it

### `docker run -v $(pwd):/mnt -p 9090:9090 -w mytest ./scripts/run.sh`

## test it

### `docker run -v $(pwd):/mnt -p 9090:9090 -w /mnt mytest ./scripts/test.sh`