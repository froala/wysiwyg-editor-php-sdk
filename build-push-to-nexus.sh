#!/bin/bash

if [ ${TRAVIS_PULL_REQUEST} != "false" ];  then echo "Not publishing a pull request !!!" && exit 0; fi

export BRANCH_NAME=`echo "${TRAVIS_BRANCH}" | tr '[:upper:]' '[:lower:]'`
case "${BRANCH_NAME}" in
        dev*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI/CD" ;;
	       ao-dev*)echo "Branch ${TRAVIS_BRANCH} is eligible for CI/CD"  ;;
        qa*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI/CD"  ;;
	       qe*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI/CD"  ;;
	       rc*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI/CD"  ;;
	       release-master*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI/CD"  ;;
        ft*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI" ;;
        bf*) echo "Branch ${TRAVIS_BRANCH} is eligible for CI" ;;
        *) echo "Not a valid branch name for CI/CD" && exit -1;;
esac

echo $TRAVIS_BRANCH
echo ${DEPLOYMENT_SERVER}
export SHORT_COMMIT=`git rev-parse --short=7 ${TRAVIS_COMMIT}`
echo "short commit $SHORT_COMMIT"
sudo apt-get update && sudo apt-get install -y jq unzip zip
PACKAGE_NAME=`jq '.name' version.json | tr -d '"'` 
PACKAGE_VERSION=`jq '.version' version.json | tr -d '"'`
ARCHIVE_NAME="${BUILD_REPO_NAME}-${TRAVIS_BRANCH}-${PACKAGE_VERSION}.zip"
zip -r "/tmp/${ARCHIVE_NAME}" .
mv "/tmp/${ARCHIVE_NAME}" ./
echo "archive name : ${ARCHIVE_NAME}"
ls -latrh
curl -k --user "${NEXUS_USER}:${NEXUS_USER_PWD}"  --upload-file ${ARCHIVE_NAME}  https://nexus.tools.froala-infra.com/repository/Froala-raw-repo/${BUILD_REPO_NAME}/${ARCHIVE_NAME}
exit $?
