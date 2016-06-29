import http from 'http'
import _ from 'underscore'
import express from 'express'
import mysql from 'mysql'
import parallel from 'node-parallel'

try { require('dotenv').config() } catch (e) { /* Do nothing */ }

const port = process.env['SERVER_PORT']
const timeout = process.env['REQUEST_TIMEOUT']
const udids = process.env['UDIDS'].split(',')

let client = mysql.createConnection({
	host: process.env['MYSQL_HOST'],
	user: process.env['MYSQL_USER'],
	password: process.env['MYSQL_PASSWORD'],
	database: process.env['MYSQL_DATABASE'],
})
client.connect()

// Keep alive
setInterval(() => {
	client.query('SELECT 1')
}, 5 * 60 * 1000)

// Server
let app = express()

app.use(express.static('src/public'))

function format (udid,data) {
	let properties = Object.assign({}, data)
	properties.udid = udid
	delete properties._raw
	delete properties.modified
	return {
		geometry: {
			type: 'Point',
			coordinates: [data.lat, data.long],
		},
		type: 'Feature',
		properties,
	}
}

app.get('/data', (req, res) => {
	let p = parallel().timeout(timeout)

	udids.forEach((udid) => {
		p.add((done) => {
			client.query('SELECT * FROM ?? ORDER BY timestamp DESC LIMIT 1', [udid], (err, rows) => {
				if (err) return done(err)
				if ( ! rows[0]) return done()
				done(null, format(udid, rows[0]))
			})
		})
	})

	p.done((err, results) => {
		if (err) {
			res.writeHead(500, { 'Content-Type': 'application/json' })
			res.end(JSON.stringify(err))
			return
		}

		res.writeHead(200, { 'Content-Type': 'application/json' })
		res.end(JSON.stringify(_.filter(results)))
	})
})

app.listen(port)
console.log('Listening on port', port)
