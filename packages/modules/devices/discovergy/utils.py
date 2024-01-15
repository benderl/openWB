from typing import Callable, Union
from requests import Session
from requests.adapters import HTTPAdapter
from requests.packages.urllib3.poolmanager import PoolManager
import ssl

from modules.common.component_state import CounterState
from modules.common.fault_state import ComponentInfo
from modules.devices.discovergy.api import get_last_reading
from modules.devices.discovergy.config import DiscovergyCounterSetup, DiscovergyInverterSetup


class DiscovergyComponent:
    def __init__(self,
                 component_config: Union[DiscovergyCounterSetup, DiscovergyInverterSetup],
                 persister: Callable[[CounterState], None]):
        self.__meter_id = component_config.configuration.meter_id
        self.store = persister
        self.component_info = ComponentInfo.from_component_config(component_config)
        self.component_config = component_config

    def update(self, session: Session):
        self.store(get_last_reading(session, self.__meter_id))


class DiscovergyHttpAdapter(HTTPAdapter):
    def init_poolmanager(self, connections, maxsize, block=False):
        self.poolmanager = PoolManager(num_pools=connections,
                                       maxsize=maxsize,
                                       block=block,
                                       ssl_version=ssl.PROTOCOL_TLSv1_2)
