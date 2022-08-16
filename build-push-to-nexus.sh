if [ ${TRAVIS_PULL_REQUEST} != "false" ];  then echo "Not publishing a pull request !!!" && exit 0; fi
#  Validate that this is a valid branch for CI/CD
#
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
# get the short commit ID to use it as docker image tag
export SHORT_COMMIT=`git rev-parse --short=7 ${TRAVIS_COMMIT}`
echo "short commit $SHORT_COMMIT"
sudo apt-get update && sudo apt-get install -y jq unzip zip
PACKAGE_VERSION=`jq '.version' composer.json | tr -d '"'`
# archive and upload to nexus raw repo
ARCHIVE_NAME="${BUILD_REPO_NAME}-${TRAVIS_BRANCH}-${PACKAGE_VERSION}.zip"
#tar -cvf "/tmp/${ARCHIVE_NAME}" .
zip -r "/tmp/${ARCHIVE_NAME}" .
mv "/tmp/${ARCHIVE_NAME}" ./
echo "archive name : ${ARCHIVE_NAME}"
ls -latrh
# push it to nexus
curl -k --user "${NEXUS_USER}:${NEXUS_USER_PWD}"  --upload-file ${ARCHIVE_NAME}  https://nexus.tools.froala-infra.com/repository/Froala-raw-repo/${BUILD_REPO_NAME}/${ARCHIVE_NAME}
exit $?
