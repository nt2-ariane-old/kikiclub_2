var mysql = require('mysql');

var connection = mysql.createConnection({
    host: "localhost",
    user: "kikiclub",
    database: "kikiclub",
    password: "mors.crai-woox5GROM",
    insecureAuth: true
});
const query = (res, sql, params = []) => {
    try {
        // connection.connect();
        connection.query(sql, params, async (error, results, fields) => {
            if (error) throw error;
            return res
                .status(200)
                .json(results);
        });

        // connection.end();
    }
    catch (e) {

        return res
            .status(404)
            .json({ success: false, error: e, label: `Element not found`, })
    }
}

const tokenQuery = async (res, params) => {
    try {
        const getUserId = "SELECT id_user FROM connect_token WHERE token=?"
        const deleteToken = "DELETE FROM connect_token WHERE token=?"
        const getUser = "SELECT * FROM users WHERE id=?"


        connection.query(getUserId, params, async (error, results, fields) => {
            if (error) throw error;
            if (results[0]) {
                const id = results[0].id_user

                connection.query(deleteToken, params, async (error, results, fields) => {
                    connection.query(getUser, [id], async (error, results, fields) => {
                        return res
                            .status(200)
                            .json({ user: results[0] });
                    })
                })
            }
        });

        // connection.end();
    }
    catch (e) {
        return res
            .status(404)
            .json({ success: false, error: `Element not found` })
    }
}
const loginQuery = async (res, params) => {
    try {
        const getUser = "SELECT * FROM users WHERE email=?"
        const registerUser = "INSERT INTO users(email,firstname,lastname,visibility,token) VALUES(?,?,?,?,?)"
        const addToken = "INSERT INTO connect_token (id_user,token) VALUES ( ? , ? )"
        let login_token = require('crypto').randomBytes(16).toString('hex');

        await connection.query(getUser, [params[0]], async (error, results, fields) => {
            if (error) {
                console.log(error);
                throw error;
            }
            if (!results[0]) {
                await connection.query(registerUser, params, async (error, results, fields) => {
                    if (error) {
                        console.log(error);
                        throw error;
                    }
                    await connection.query(addToken, [results[0].id, login_token], async (error, results, fields) => {

                        if (error) {
                            console.log(error);
                            throw error;
                        }
                        return res
                            .status(200)
                            .json({ token: login_token });

                    })
                })
            }
            else {
                await connection.query(addToken, [results[0].id, login_token], async (error, results, fields) => {
                    if (error) {
                        console.log(error);
                        throw error;
                    }
                    return res
                        .status(200)
                        .json({ token: login_token });
                })
            }



        });
        console.log("END LOGIN")

        // connection.end();
    }
    catch (e) {
        console.log(e)
        return res
            .status(404)
            .json({ success: false, error: `Element not found` })
    }
}

module.exports = {
    query: query,
    tokenQuery: tokenQuery,
    loginQuery: loginQuery,
};
// module.exports = query
// module.exports = loginQuery